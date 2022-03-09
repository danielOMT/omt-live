export default () => {
    // TODO: Pass name as a prop
    return {
        showModal: false,
        name: null,

        open(name = null) {
            if (name === null || (typeof name === 'object' && Object.keys(name).length === 0) || name === this.name) {
                this.showModal = true;
            }
        },

        close(name = null) {
            if (name === null || (typeof name === 'object' && Object.keys(name).length === 0) || name == this.name) {
                this.showModal = false;
            }
        }
    };
};
