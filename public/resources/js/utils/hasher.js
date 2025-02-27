/**
 * Hashes the input data using SHA-256.
 *
 * @param {string | number} data - The input data to be hashed.
 * @returns {Promise<string>} A promise that resolves to the hexadecimal SHA-256 hash.
 */
async function hashIt(data) {
    const encoder = new TextEncoder();
    const encodedData = encoder.encode(String(data)); //REM: Convert to string to handle numbers
    const hashBuffer = await crypto.subtle.digest("SHA-256", encodedData);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
    return hashHex;
}