<style>
    @media (hover: hover) and (pointer: fine) {
        :root {
            --cursor-default: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAM9SURBVFhHxZdLaBNBGMd3k9RkNwpGNiGLJkXwoCdBFFHUoAhaPfgsCIq1Up8XJQe9KVrxcVFR8FURETz0oCIqCNpWfNCiUkFoNU2b1narlbY22Hbb7iYzft/s9kVrm8Zk/cOf2Z2dxy/fzM5+4Xiej+XYbIXc/xLPcwNQJMFbWIXVEp18y8ndrg67jSNwu9WotVZKvMLb87B4BoVrjMQ2VmuhlNpXskrbZtPbYXcP3CNEPntikZTacn8v7cilpFFOlIRFhIBo2C2LhAHwM0gTzUFKYnKyJOzuhXrcnOtYiyzLAGgLUi0WMCAgErfCbhWe9YPXs1ZZ1CgAtG5G4sYREfeDBs5jLbOkMQBDkWiQyZXDIkYCITay1lnQuABaowkRk/VLh0TcEzpnt2cFYnwA02YkEiYEbsyVrFcGNSHAUCQA4vJBthzd4FWsZ4Y0MQB6BMTFA6IOfTAaIdY7A5ocAG1C0KhMLxQJCeiHEKvZCP+o1ADQg5GI+hNn9gi4HCpszDXGMOkrdQD0IES9Xzch+jjOscIYKj1NDQANEMlhCADg4uAlbLQ01FxTNkUA9PBy6MUFAp6Y6UE8uyc19tYFSKJpnEkm8yBExE9O7BIwoUGIpWzgVFVR6o2p9QGi/wUgCfW0K5fSOBjLX6Y7we2m4Zo0yeR0gYAfr26Hw7HMGD01fRuzBPDLsKQK/LqWQOL6WY92tdhDb56fpZdek+ijEqnv6V2p//UDn1b52KdWP/fT6DtZbS+XtKI8J+QTfI/L5Vhujj+pRm/CJigjcyip9FHy2TewdxNbXwX8AlwGrgZXgb+CI+A6cCe4VRT4ft9M228eEhpIdpuhLiUNA+DkUZj8jURJlZTct8GJX0GcfC5rOUKhUMgBhRMsgCWwF4zt5uXkcIugXAhOSQYArKVWD5O/9VLyXtLC+QImqd85btp8o1n2BEkpAPwI0iRO/kFKHtvBNlMHeAFrkWUptS8B4BOs+UdJP1UoYti7wIvZUwukfLnvUUmNl5zbL+Kphp9byyZHKfEnnu47x6djsoFne0a+cCnL7eJbj2534XrjSbaWVVopeF8xwcB3fTOrsFrw97zBZrPtNG8tFsf9AZKe/ut982c1AAAAAElFTkSuQmCC') 3 2, auto;
            --cursor-pointer: var(--cursor-default);
        }

        html, body, div, section, article, header, nav, footer, main, p, span, h1, h2, h3, h4, h5, h6, ul, li, img, aside, figure, table, tr, td, th {
            cursor: var(--cursor-default) !important;
        }

        a, button, [role="button"], input[type="submit"], input[type="button"], select, label[for], summary, .cursor-pointer {
            cursor: var(--cursor-pointer) !important;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="search"], textarea, [contenteditable="true"] {
            cursor: text !important;
        }

        [disabled], .cursor-not-allowed {
            cursor: not-allowed !important;
        }
    }
</style>
