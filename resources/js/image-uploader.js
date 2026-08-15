import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

/* ============================================================
   IMAGE UPLOADER — live preview + crop for admin forms.
   - ONLY WebP and SVG files are accepted; anything else is
     rejected immediately with an error message.
   - Shows an instant preview of the selected file.
   - Opens a Cropper.js modal for WebP; SVG is previewed as-is
     (no crop possible).
   - The cropped result (WebP) replaces the file in the original
     input so the form submits the cropped image.
   ============================================================ */

const RATIOS = ['free', '1', '4/3', '3/2', '16/9', '21/9'];

const ERROR_FORMAT = 'Format tidak didukung. Hanya file WebP atau SVG yang diperbolehkan.';

function parseRatio(value) {
    if (!value || value === 'free') return NaN;

    const [w, h] = String(value).split('/').map(Number);
    if (w && h) return w / h;

    return Number(value) || NaN;
}

function ratioLabel(value) {
    if (value === 'free') return 'Bebas';

    const [w, h] = String(value).split('/');
    return h ? `${w}:${h}` : '1:1';
}

document.addEventListener('alpine:init', () => {
    Alpine.data('imageUploader', (config = {}) => ({
        // Props (from the Blade component)
        currentSrc: config.current || '',
        defaultRatio: config.ratio || 'free',
        allowCrop: config.crop !== false,
        ratios: RATIOS,

        // State
        previewSrc: config.current || '',
        objectUrl: null,
        fileName: '',
        isSvg: false,
        originalFile: null,
        showCrop: false,
        ratio: config.ratio || 'free',
        cropper: null,
        errorMsg: '',

        init() {
            this.$refs.fileInput.addEventListener('change', () => this.onFileChange());
        },

        onFileChange() {
            const input = this.$refs.fileInput;
            const file = input.files && input.files[0];
            if (!file) return;

            // Only WebP and SVG are allowed — reject everything else right away
            // and keep the previous selection intact.
            const name = (file.name || '').toLowerCase();
            const isWebp = file.type === 'image/webp' || name.endsWith('.webp');
            const isSvg = file.type === 'image/svg+xml' || name.endsWith('.svg');

            if (!isWebp && !isSvg) {
                input.value = '';
                this.revokePreview();
                this.previewSrc = this.currentSrc;
                this.fileName = '';
                this.isSvg = false;
                this.originalFile = null;
                this.destroyCropper();
                this.errorMsg = ERROR_FORMAT;
                return;
            }

            this.errorMsg = '';
            this.isSvg = isSvg;
            this.originalFile = file;
            this.fileName = file.name;

            this.revokePreview();
            this.previewSrc = URL.createObjectURL(file);
            this.objectUrl = this.previewSrc;

            // WebP opens the crop modal automatically; SVG just previews.
            if (!isWebp && this.allowCrop) {
                this.openCrop(this.previewSrc);
            }
        },

        openCrop(url) {
            this.showCrop = true;
            this.ratio = this.defaultRatio;

            this.$nextTick(() => {
                const image = this.$refs.cropImage;
                image.onload = () => {
                    if (this.cropper) this.cropper.destroy();
                    this.cropper = new Cropper(image, {
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.9,
                        background: true,
                        responsive: true,
                        checkOrientation: true,
                        aspectRatio: parseRatio(this.defaultRatio),
                    });
                };
                image.onerror = () => {
                    // Browser can't render this file — close the modal but keep
                    // the file in the input. Only clear on explicit user action.
                    this.showCrop = false;
                    this.destroyCropper();
                };
                image.src = url;
            });
        },

        setRatio(value) {
            this.ratio = value;
            if (this.cropper) {
                this.cropper.setAspectRatio(parseRatio(value));
            }
        },

        rotate(degrees) {
            if (this.cropper) this.cropper.rotate(degrees);
        },

        resetCrop() {
            if (this.cropper) this.cropper.reset();
        },

        cancelCrop() {
            this.showCrop = false;
            this.destroyCropper();
        },

        applyCrop() {
            if (!this.cropper) return;

            const canvas = this.cropper.getCroppedCanvas({
                maxWidth: 2000,
                maxHeight: 2000,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Cropped results are always WebP (keeps transparency and stays
            // within the accepted WebP/SVG-only formats).
            canvas.toBlob((blob) => {
                if (!blob) return;

                const base = (this.originalFile?.name || 'gambar').replace(/\.[^.]+$/, '');
                const croppedFile = new File([blob], `${base}-crop.webp`, { type: 'image/webp' });

                // Replace the input's file with the cropped version so the
                // form uploads exactly what the user cropped.
                const dt = new DataTransfer();
                dt.items.add(croppedFile);
                this.$refs.fileInput.files = dt.files;

                this.fileName = croppedFile.name;
                this.revokePreview();
                this.previewSrc = URL.createObjectURL(blob);
                this.objectUrl = this.previewSrc;
                this.showCrop = false;
                this.destroyCropper();
            }, 'image/webp', 0.92);
        },

        destroyCropper() {
            if (this.cropper) {
                this.cropper.destroy();
                this.cropper = null;
            }
        },

        revokePreview() {
            if (this.objectUrl) {
                URL.revokeObjectURL(this.objectUrl);
                this.objectUrl = null;
            }
        },

        clearSelection() {
            this.revokePreview();
            this.$refs.fileInput.value = '';
            this.previewSrc = this.currentSrc;
            this.fileName = '';
            this.isSvg = false;
            this.originalFile = null;
            this.errorMsg = '';
            this.destroyCropper();
        },

        ratioLabel,
    }));
});
