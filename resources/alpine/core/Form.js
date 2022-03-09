import Errors from "./Errors";

class Form {
    constructor(data) {
        this.loading = false;
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    data() {
        let data = new FormData();

        for (let property in this.originalData) {
            data.append(property, this[property]);
        }

        return data;
    }

    post(url, action, nonce) {
        return this.submit("POST", url, action, nonce);
    }

    submit(requestType, url, action, nonce) {
        let data = this.data();
        data.append("action", action);
        data.append("nonce", nonce);

        this.loading = true;
        this.errors.clear();

        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                type: requestType,
                dataType: "json",
                data: data,
                processData: false,
                contentType: false
            })
            .done(response => {
                resolve(response);
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                let response =
                    jqXHR.responseJSON && jqXHR.responseJSON.response
                        ? jqXHR.responseJSON.response
                        : null;

                if (response.errors) {
                    this.errors.add(response.errors);
                }

                reject(response);
            })
            .always(() => {
                this.loading = false;
            });
        });
    }
}

export default Form;
