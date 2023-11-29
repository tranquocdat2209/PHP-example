function deleteRow(id = 0, url = '') {
    if (confirm('Are you sure you want to delete')) {
        $.ajax({
            type: "POST",
            url: url,
            data: {id},
            dataType: "json",
            success: function (res) {
                if (res['status'] == true) {
                    window.location.reload();
                }
            }
        })
    }
}



