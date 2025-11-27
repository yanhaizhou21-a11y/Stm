// Modal management utilities
export class ModalManager {
    constructor(modalId) {
        this.modalId = modalId;
        this.modal = document.getElementById(modalId);
        this.closeButtons = document.querySelectorAll(`[data-close-modal="${modalId}"]`);
        this.init();
    }

    init() {
        // Add click handlers to close buttons
        this.closeButtons.forEach(btn => {
            btn.addEventListener('click', () => this.close());
        });

        // Close on overlay click
        if (this.modal) {
            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.close();
                }
            });
        }

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
                this.close();
            }
        });
    }

    open() {
        if (this.modal) {
            this.modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        return this;
    }

    close() {
        if (this.modal) {
            this.modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
        return this;
    }

    resetForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
        }
        return this;
    }

    populateForm(formId, data) {
        const form = document.getElementById(formId);
        if (form) {
            Object.keys(data).forEach(key => {
                const input = form.querySelector(`[name="${key}"], #${key}`);
                if (input) {
                    if (input.type === 'checkbox') {
                        input.checked = Boolean(data[key]);
                    } else {
                        input.value = data[key];
                    }
                }
            });
        }
        return this;
    }

    setTitle(title) {
        const titleElement = this.modal?.querySelector('h3');
        if (titleElement) {
            titleElement.textContent = title;
        }
        return this;
    }
}

// Helper function to create modal with form handlers
export function setupModal(modalId, formId, options = {}) {
    const modal = new ModalManager(modalId);
    const form = document.getElementById(formId);

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            // Convert checkbox values
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => {
                data[cb.name] = cb.checked ? 1 : 0;
            });

            if (options.onSubmit) {
                await options.onSubmit(data, formData);
            }
        });
    }

    return modal;
}

// Global modal helper
window.openModal = function (modalId) {
    new ModalManager(modalId).open();
};

window.closeModal = function (modalId) {
    new ModalManager(modalId).close();
};
