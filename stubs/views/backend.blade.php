<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite('resources/scss/vendor.scss')
    @vite('resources/scss/fontawesome.scss')
    @vite('resources/scss/backend.scss')

    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script>

    @vite('resources/js/app.js')
    <style>
        #loader-container{position:fixed;top:0;bottom:0;left:0;right:0;z-index:100003;display:flex;align-items:center;justify-content:center}#loader-container #loader{display:block;position:relative;width:150px;height:150px;border-radius:50%;border:3px solid transparent;border-top-color:#3498db;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite;z-index:1001}#loader-container #loader:before{content:"";position:absolute;top:5px;right:5px;left:5px;bottom:5px;border-radius:50%;border:3px solid transparent;border-top-color:#e74c3c;-webkit-animation:spin 3s linear infinite;animation:spin 3s linear infinite}#loader-container #loader:after{content:"";position:absolute;top:15px;right:15px;left:15px;bottom:15px;border-radius:50%;border:3px solid transparent;border-top-color:#f9c922;-webkit-animation:spin 1.5s linear infinite;animation:spin 1.5s linear infinite}#loader-container .loader-section{position:fixed;top:0;width:51%;height:100%;background:#222;z-index:1000;transform:translateX(0)}#loader-container .loader-section.section-left{right:0}#loader-container .loader-section.section-right{left:0}#loader-container.loaded{visibility:hidden;transform:translateY(-100%);transition:all .3s 1s ease-out}#loader-container.loaded #loader{opacity:0;transition:all .3s ease-out}#loader-container.loaded .loader-section.section-left{transform:translateX(100%);transition:all .7s .3s cubic-bezier(.645,.045,.355,1)}#loader-container.loaded .loader-section.section-right{transform:translateX(-100%);transition:all .7s .3s cubic-bezier(.645,.045,.355,1)}
    </style>
    @inertiaHead
</head>
<body>
@inertia
<div id="modal-place"></div>
<div id="loader-container"><div id="loader"></div><div class="loader-section section-left"></div><div class="loader-section section-right"></div></div>
</body>
</html>
