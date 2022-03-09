function xModal(name = null) {
    return {
        showModal: false,
        name: name,

        open(name = null) {
            if (!name || name == this.name) {
                this.showModal = true;
            }
        },

        close(name = null) {
            if (!name || name == this.name) {
                this.showModal = false;
            }
        }
    };
}
