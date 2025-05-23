/*  removeStorage: removes a key from localStorage and its sibling expiracy key
    params:
        key <string>     : localStorage key to remove
    returns:
        <boolean> : telling if operation succeeded
 */
const StorageName = "Technicyon_";
function removeStorage(name) {
    try {
        localStorage.removeItem(name);
        localStorage.removeItem(name + "_expiresIn");
    } catch (e) {
        console.log(
            "removeStorage: Error removing key [" +
                key +
                "] from localStorage: " +
                JSON.stringify(e)
        );
        return false;
    }
    return true;
}
/*  getStorage: retrieves a key from localStorage previously set with setStorage().
                params:
                  key <string> : localStorage key
                returns:
                  <string> : value of localStorage key
                  null : in case of expired key or failure
          */
function getStorage(key) {
    key = StorageName + key;
    var now = Date.now(); //epoch time, lets deal only with integer
    // set expiration for storage
    var expiresIn = localStorage.getItem(key + "_expiresIn");
    if (expiresIn === undefined || expiresIn === null) {
        expiresIn = 0;
    }

    if (expiresIn < now) {
        // Expired
        removeStorage(key);
        return null;
    } else {
        try {
            var value = localStorage.getItem(key);
            try {
                value = JSON.parse(value);
                return value.data ? value.data : null;
            } catch (e) {
                return null;
            }
            // return value;
        } catch (e) {
            alert(JSON.stringify(e));
            console.log(
                "getStorage: Error reading key [" +
                    key +
                    "] from localStorage: " +
                    JSON.stringify(e)
            );
            return null;
        }
    }
}
/*  setStorage: writes a key into localStorage setting a expire time
                params:
                  key <string>     : localStorage key
                  value <string>   : localStorage value
                  expires <number> : number of seconds from now to expire the key
                returns:
                  <boolean> : telling if operation succeeded
          */
function setStorage(key, value, expires) {
    let expiresTime = 365 * 24 * 60 * 60; // default: seconds for 1 year
    key = StorageName + key;
    if (expires === undefined || expires === null) {
        expires = expiresTime; // default: seconds for 1 day
        // expires = (5); // default: seconds for 1 day
    } else {
        expires = Math.abs(expires); //make sure it's positive
    }
    var now = Date.now(); //millisecs since epoch time, lets deal only with integer
    var schedule = now + expires * 1000;
    try {
        /*
        if(typeof value === "object")
            value = JSON.stringify(value);
        */
        var dataObj = JSON.stringify({ data: value });
        localStorage.setItem(key, dataObj);
        localStorage.setItem(key + "_expiresIn", schedule);
    } catch (e) {
        console.log(
            "setStorage: Error setting key [" +
                key +
                "] in localStorage: " +
                JSON.stringify(e)
        );
        return false;
    }
    return true;
}