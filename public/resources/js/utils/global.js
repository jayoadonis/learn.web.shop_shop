
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


// /**
//  * @typedef {Object.<string,string>} header
//  * 
//  */

/**
 * 
 * @typedef {{ [key: string]: string }} Header
 * 
 */

/**
 * 
 * @typedef {{ [key: string]: string|number }} Footer
 */


/**
 * @typedef {Object} LetterContainer
 * @property {Header} header - The headers.
 * @property {string | Document | Blob | FormData | ArrayBuffer | URLSearchParams | null} body - The request/response body.
 * @property {Footer} footer - Additional metadata.
 */


/**
 * 
 * @callback ResponseCallBack
 * @param {Error|null} error - The error if one occurred, otherwise null.
 * @param {Object} response - The response object.
 * @param {string|number} response.status - The HTTP status code.
 * @param {string} response.statusText - The HTTP status text.
 * @param {LetterContainer} response.letter - The letter container with parsed response headers, body, and footer.
 * @return {void}
 * 
 */



/**
 * Sends an HTTP request using XMLHttpRequest.
 *
 * @param {string} method - The HTTP method (e.g., "GET", "POST").
 * @param {string|URL} url - The request URL.
 * @param {LetterContainer} requestLetter - The letter container for the request, containing header, body, and footer.
 * @param {ResponseCallBack} callback - The callback function (error, response) to be invoked on completion.
 * @param {boolean} [isAsync=true]
 * @return {void}
 */
function xmlHttpRequest(
    method, 
    url,
    requestLetter,
    callback,
    isAsync
 ) {
 
     var xmlHttpReq = new XMLHttpRequest();
 
     xmlHttpReq.open( method, url, isAsync||true);
 
     if( requestLetter 
         && requestLetter.header 
         && typeof requestLetter.header === "object"
     ) {
 
         Object.keys(requestLetter.header).forEach(function(key){
             xmlHttpReq.setRequestHeader(key, requestLetter.header[key]);
         });
     }
 
     xmlHttpReq.onload = function( ev ) {
         var status      = xmlHttpReq.status;
         var statusText  = xmlHttpReq.statusText;
         var response    = xmlHttpReq.response;
         var contentType = xmlHttpReq.getResponseHeader("Content-Type") || "";
 
 
         if( contentType.includes("application/json") !== -1 ) {
 
             try {
                 response = JSON.parse(xmlHttpReq.responseText);
             }
             catch( e ) {
                 console.error( "Failed to parse JSON response:", e );
             }
         }
         else if( contentType.includes("application/xml") !== -1 
             && contentType.includes("text/xml") !== -1
         ) {
 
             response = xmlHttpReq.responseXML;
         }
         else if( contentType.includes("text/") !== -1 ) {
 
             response = xmlHttpReq.responseText;
         }
 
         var letterContainerResponse = {
             header: parseResponseHeader(xmlHttpReq.getAllResponseHeaders()),
             body: response,
             footer: {
                 timestamp: Date.now()
             }
         };
 
         callback( 
             null,
             {
                 status: status,
                 statusText: statusText,
                 letter: letterContainerResponse
             }
         )
     };
     
     xmlHttpReq.onerror = function( ev ) {
 
         callback( (new Error("Network error while making request to " + url ), {}) );
     };
 
     xmlHttpReq.send(
 
         requestLetter && (requestLetter.body? requestLetter.body : null ) 
     )
 }
 
 
 /**
  * 
  * @param {string} headerStr
  * @return {Header}  
  */
 function parseResponseHeader( headerStr ) {
 
     /**
      * @type {Header} $headerObj
      */
     var headerObj = {};
 
     if( ! headerStr ) return headerObj;
 
     var headerLines = headerStr.trim().split(/[\r\n]+/);
 
     headerLines.forEach( function( line ) {
         
         var parts       = line.split(/:\s+/);
         var popedPart   = parts.shift(); //REM: pop first element.
         var key         = (popedPart != null)? popedPart.trim() : undefined; 
         var value       = parts.join(": "); 
 
         if( key !== undefined ) {
 
             headerObj[key] = value;
     
             // Object.defineProperty(
             //     headerObj, 
             //     key, 
             //     {
             //         value: value,
             //         writable: true,
             //         enumerable: true,
             //         configurable: true
             //     }
             // );
         }
     });
 
     return headerObj;
 }