function sendRequestPromise(url, method, data) {
    return new Promise((resolve, reject) => {
        const isFormData = data instanceof FormData;

        $.ajax({
            url,
            type: method,
            data,
            dataType: 'json',
            processData: !isFormData,
            contentType: !isFormData ? 'application/x-www-form-urlencoded; charset=UTF-8' : false,
            cache: false,
            success: function (response) {
                console.log("AJAX response:", response);

                if (response.success) {
                    resolve(response);
                } else {
                    reject(new Error(response.message || 'Unknown error'));
                }
            },
            error: function (xhr) {
                console.error("AJAX failed:", xhr);
                reject(new Error(xhr.responseText || 'Request failed'));
            }
        });
    });
}
