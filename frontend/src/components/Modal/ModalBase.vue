<template>
    <div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <header class="modal-header">
                        <slot name="header"></slot>
                    </header>
                    <main class="modal-body">
                        <slot name="body"></slot>
                    </main>
                    <footer class="modal-footer">
                        <slot name="footer"></slot>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>