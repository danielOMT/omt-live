function xModal(name = null) {
    return {
        showModal: false,
        name: name,

        open(name = null) {
            if (!name || name == this.name) {
                setTimeout(() => {
                    this.showModal = true; 
                }, 200);
            }
        },

        close(name = null) {
            if (!name || name == this.name) {
                this.showModal = false;
                $('.ticket').removeClass('noHover');
            }
        }
    };
}
