function xToolsAlternativesStats() {
    return {
        getStats() {
            $.ajax({
                url: omt_tools_alternatives_stats.ajax_url,
                dataType: "json",
                data: {
                    action: "omt_tools_alternatives_stats"
                },
                success: function (data, textStatus, XMLHttpRequest) {
                    $('#count-enabled-alternatives').text(data.enabled);
                    $('#count-disabled-alternatives').text(data.disabled);
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    };
}
