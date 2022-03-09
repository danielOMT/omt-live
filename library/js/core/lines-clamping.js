function xLinesClamping() {
    return {
        clamp(lines = 2) {
            let truncateText = this.$el.getAttribute("title");
            let lineHeight = parseFloat(
                window.getComputedStyle(this.$el)["line-height"]
            );
            let display = window.getComputedStyle(this.$el)["display"];

            this.$el.style.display = "inline-block";
            this.$el.innerHTML = truncateText;

            while (lines * lineHeight < this.$el.clientHeight) {
                truncateText = truncateText.substring(
                    0,
                    truncateText.length - 1
                );
                this.$el.innerHTML = truncateText + "...";
            }

            this.$el.style.display = display;
        }
    };
}
