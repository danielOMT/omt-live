import Modal from "../../../core/Modal";
import debounce from "lodash/debounce";

window.xModal = Modal;

export default () => {
    return {
        loading: true,
        availableFilters: null,
        details: null,
        enums: {},
        items: [],
        filters: [],
        zip: '',
        filterSelect: {
            key: 0,
            operator: "=",
            value: 0
        },

        init() {
            this.$watch(`zip`, debounce(() => {
                this.fetch();
            }, 300));

            this.fetch(true);
        },
        
        fetch(initialization = false) {
            this.loading = true;

            $.ajax({
                url: this.$refs.root.dataset.url,
                dataType: "json",
                data: {
                    action: "omt_admin_job_profiles",
                    initialization,
                    filters: this.filters,
                    zip: this.zip
                }
            }).done((response) => {
                if (initialization) {
                    this.enums = response.data.enums;
                    this.availableFilters = response.data.filters;
                }

                this.items = response.data.items;
            }).always(() => {
                this.loading = false;
            });
        },

        addFilter() {
            if (this.filterSelect.key !== 0 && this.filterSelect.value !== 0) {
                this.filters.push({
                    key: this.filterSelect.key,
                    operator: this.filterSelect.operator,
                    value: this.filterSelect.value
                });

                this.filterSelect.key = 0;
                this.filterSelect.operator = "=";
                this.filterSelect.value = 0;

                this.fetch();
            }
        },

        deleteFilter(index) {
            // Reactivity problem when 'delete' element from array, use filter() instead
            this.filters = this.filters.filter((filter, key) => { return key !== index });
            this.fetch();
        },

        filterSelectOperators() {
            if (this.filterSelect.key) {
                return this.availableFilters[this.filterSelect.key].operators;
            }

            return ['='];
        },

        filterSelectValues() {
            if (this.filterSelect.key) {
                return this.availableFilters[this.filterSelect.key].options;
            }

            return [];
        },

        filterSelectType() {
            if (this.filterSelect.key) {
                return this.availableFilters[this.filterSelect.key].type;
            }

            return 'select';
        },

        formatDate(dateStr) {
            const date = new Date(dateStr);
            let month = date.getMonth() + 1;

            if (month < 10) {
                month = `0${month}`;
            }

            return `${date.getDate()}.${month}.${date.getFullYear()}`;
        }
    };
};
