function getUrlParameters() {
    const url = window.location.href;

    const queryString = url.split('?')[1];
    if (!queryString) {
        return {};
    }

    const params = queryString.split('&');
    const result = {};

    params.forEach(param => {
        const [key, value] = param.split('=');
        result[decodeURIComponent(key)] = decodeURIComponent(value || '');
    });

    return result;
}

function getFormData(form) {
    const formData = new FormData(form);
    const jsonData = {};
    const arrayFields = new Set();

    for (let element of form.elements) {
        if (element.name && element.name.endsWith('[]')) {
            arrayFields.add(element.name);
        }
    }

    arrayFields.forEach(name => {
        jsonData[name] = [];
    });

    formData.forEach((value, key) => {
        const trimmed = value.trim();

        if (arrayFields.has(key)) {
            if (trimmed !== '') {
                jsonData[key].push(trimmed);
            }
        } else {
            jsonData[key] = trimmed !== '' ? trimmed : null;
        }
    });

    return jsonData;
}