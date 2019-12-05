/**
 * Handles response from server for AJAX/AJAJ request
 * @param {XMLHttpRequest} httpRequest : XMLHttpRequest instance
 * @return {void}
 */
const handleReadyState = (httpRequest, callback) => {
    try {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) callback(httpRequest.responseText);
            else alert("There was a problem with the request!");
        }
    } catch (error) {
        throw `Caught exception: ${error}`;
    }
}

/**
 * Creates new ajax post request
 * @param {String} url : url to which the data will be sent
 * @param {*} data : data to send
 * @return {boolean} : whether or not the request could be executed properly
 */
const post = (url, data, callback) => {
    const httpRequest = new XMLHttpRequest();

    // Handle instance problem
    if (!httpRequest) {
        alert("The XMLHttpRequest instance could not be created!");
        return false;
    }

    httpRequest.onreadystatechange = () => handleReadyState(httpRequest, callback);
    httpRequest.open('POST', url); // Post to given url
    httpRequest.send(data); // Send the given data
    return true;
}