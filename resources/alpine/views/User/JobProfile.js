import Form from "../../core/Form";

export default () => {
    return {
        noticeType: null,
        message: null,
        file: null,
        enums: [],
        form: new Form({
            salutation: "",
            firstname: "",
            lastname: "",
            email: "",
            phone: "",
            birthdate: "",
            address: "",
            zip: "",
            city: "",
            degree: "",
            specialty: "",
            linkedin_url: "",
            resume: "",
            position: "",
            marketing_area: 0,
            branch: 0,
            experience: 0,
            experience_am: 0,
            experience_cm: 0,
            experience_em: 0,
            experience_ga: 0,
            experience_im: 0,
            experience_pr: 0,
            experience_seo: 0,
            experience_smm: 0,
            experience_vm: 0,
            experience_wd: 0,
            leadership_experience: 0,
            experience_industries: [],
            tools_knowledge: "",
            german_level: 0,
            english_level: 0,
            french_level: 0,
            spanish_level: 0,
            job_status: 0,
            job_change_reason: [],
            marketing_area_interest: [],
            annual_salary: 0,
            comment: ""
        }),

        update() {
            let alertEl = this.$refs.alertContainer;

            this.message = null;

            this.form.post(
                omt_update_job_profile.url,
                'omt_update_job_profile',
                omt_update_job_profile.nonce
            ).then(response => {
                this.setFileInfo(response.data.item);

                this.noticeType = "success";
                this.message = response.response.message;
                alertEl.scrollIntoView({ block: "center", behavior: "smooth" });
            }).catch(data => {
                this.noticeType = "error";
                this.message = data ? data.message : "Undefined error";
                alertEl.scrollIntoView({ block: "center", behavior: "smooth" });
            })
        },

        initialize() {            
            this.setContainerHeight();
            window.addEventListener("resize", () => {
                this.setContainerHeight();
            });

            // Set hidden "Aus welchen Gründen denkst Du über einen neuen Job nach?"
            this.$watch(`form.job_change_reason`, () => {
                for (let value in this.enums['job_change_reason']) {
                    this.$refs[`job_change_reason_${value}`].value = this.form.job_change_reason.includes(parseInt(value)) ? true : false;
                }
            });

            // Set hidden "In welchen Online Marketing Bereichen sind Stellen für Dich von Interesse?"
            this.$watch(`form.marketing_area_interest`, () => {
                for (let value in this.enums['marketing']) {
                    this.$refs[`marketing_area_interest_${value}`].value = this.form.marketing_area_interest.includes(value) ? true : false;
                }
            });

            // Set hidden "In welchen Branchen warst Du bzw. bist Du tätig?"
            this.$watch(`form.experience_industries`, () => {
                for (let value in this.enums['branch']) {
                    this.$refs[`experience_industries_${value}`].value = this.form.experience_industries.includes(parseInt(value)) ? true : false;
                }
            })

            this.fetch();
        },

        fetch() {
            $.ajax({
                url: omt_get_job_profile.url,
                dataType: "json",
                data: {
                    action: "omt_get_job_profile",
                    nonce: omt_get_job_profile.nonce
                }
            }).done((response) => {
                if (response.data.item) {
                    for (let property in response.data.item) {
                        if (this.form.originalData.hasOwnProperty(property)) {
                            this.form[property] = response.data.item[property];
                        }
                    }

                    this.setFileInfo(response.data.item);
                }

                this.enums = response.data.enums;

                this.setContainerHeight();
            });
        },

        setFileInfo(item) {
            if (item.resume_file) {
                this.file = {
                    file: item.resume_file,
                    name: item.resume_filename
                }
            }
        },

        watcher(property) {
            this.$watch(`form.${property}`, () => {
                // Clear form errors for this field
                this.form.errors.clear(property);

                this.$nextTick(() => {
                    this.setContainerHeight();
                })
            })
        },

        setContainerHeight() {
            document.getElementById('profile-resume-placeholder').style.height = this.$root.offsetHeight + 100 + 'px';
        }
    };
};
