
const RequestState = Object.freeze({
    UNSENT: 0,
    OPENED: 1,
    HEADERS_RECEIVED: 2,
    LOADING: 3,
    DONE: 4
});

const StatusCode = Object.freeze({
    OK: 200,
    MULT_RES: 300,
    BAD_REQUEST: 400,
    INTERNAL_SERVER_ERROR: 500
});