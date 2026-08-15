import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

/* ============================================================
   IMAGE UPLOADER — live preview + crop for admin forms.
   - Shows an instant preview of the selected file.
   - Opens a Cropper.js modal for raster images (jpg/png/gif/webp).
   - SVG files are previewed as-is (no crop possible).
   - The cropped result replaces the file in the original input
     so the form submits the cropped image.
   ============================================================ */

const RATIOS = ['free', '1', '4/3', '3/2', '16/9', '21/9'];

// Large crops are encoded as JPEG to stay well under the server's
// 4MB upload limit; small ones keep PNG (transparency-friendly).
const JPEG_PIXEL_THRESHOLD = 1200000;

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

        init() {
            this.$refs.fileInput.addEventListener('change', () => this.onFileChange());
        },

        onFileChange() {
            const input = this.$refs.fileInput;
            const file = input.files && input.files[0];
            if (!file) return;

            this.isSvg = file.type === 'image/svg+xml' || /\.svg$/i.test(file.name);
            this.originalFile = file;
            this.fileName = file.name;

            this.revokePreview();
            this.previewSrc = URL.createObjectURL(file);
            this.objectUrl = this.previewSrc;

            // Raster images open the crop modal automatically; SVG just previews.
            if (!this.isSvg && this.allowCrop) {
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
                    // Browser can't render this file (e.g. HEIC) — close the modal
                    // but KEEP the file in the input so it can still be uploaded;
                    // the server converts it. Only clear on explicit user action.
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

            // getData() reports the crop selection in natural image pixels.
            const { width: cropW, height: cropH } = this.cropper.getData();
            const useJpeg = cropW * cropH > JPEG_PIXEL_THRESHOLD;
            const type = useJpeg ? 'image/jpeg' : 'image/png';
            const ext = useJpeg ? 'jpg' : 'png';

            const canvas = this.cropper.getCroppedCanvas({
                maxWidth: 2000,
                maxHeight: 2000,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
                ...(useJpeg ? { fillColor: '#fff' } : {}),
            });

            canvas.toBlob((blob) => {
                if (!blob) return;

                const base = (this.originalFile?.name || 'gambar').replace(/\.[^.]+$/, '');
                const croppedFile = new File([blob], `${base}-crop.${ext}`, { type });

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
            }, type, 0.92);
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
            this.destroyCropper();
        },

        ratioLabel,
    }));
});
