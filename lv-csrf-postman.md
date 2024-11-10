pm.test("Response status code is 204", function () {
    pm.response.to.have.status(204);

    // Check if the XSRF-TOKEN cookie exists
    var xsrfCookie = pm.cookies.get('XSRF-TOKEN');

    if (xsrfCookie) {
        // Set the cookie value to a global variable
        pm.globals.set('XCSRF_TOKEN', xsrfCookie);
    } else {
        console.log('XSRF-TOKEN cookie not found.');
    }
});
