const Modal = {
    open(modal, detail = {}) {
        modal.style.removeProperty('display')
        document.body.classList.add('overflow-hidden')

        if (detail.related?.dataset?.action) {
            this.setFormAction(modal, detail.related)
        }

        modal.dispatchEvent(
            new CustomEvent('modal.open', {
                detail,
            })
        )
    },

    close(modal, detail = {}) {
        modal.style.setProperty('display', 'none')
        document.body.classList.remove('overflow-hidden')

        modal.dispatchEvent(
            new CustomEvent('modal.close', {
                detail,
            })
        )
    },

    setFormAction(modal, related) {
        const form = modal.querySelector('form')
        form.action = related.dataset.action
    },
}

const openTriggers = document.querySelectorAll('[data-modal-open]')
const closeTriggers = document.querySelectorAll('[data-modal-close]')
const overlay = document.querySelector('[data-modal]')

openTriggers.forEach(trigger => {
    const modal = document.querySelector(trigger.dataset.modalOpen)

    trigger.addEventListener('click', () =>
        Modal.open(modal, { related: trigger })
    )
})

closeTriggers.forEach(trigger => {
    const modal = trigger.closest('[data-modal]')

    trigger.addEventListener('click', () =>
        Modal.close(modal, { related: trigger })
    )
})

overlay?.addEventListener('click', e => {
    if (e.target === overlay) {
        Modal.close(overlay)
    }
})

window.Feadmin.Modal = Modal