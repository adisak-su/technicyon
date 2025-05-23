// function getLocalDate(val,type=null) {
// 	const d = new Date(val.substr(0, 10));
// 	let str = d.toLocaleDateString('th-TH');
// 	return str;
// }

// function getLocalDateTime(val) {
// 	const d = new Date(val);
// 	let str = d.toLocaleDateString('th-TH');
// 	return str + " " + new Intl.DateTimeFormat('th-TH', {timeStyle: 'short'}).format(d)  + " น."
// }

let statusInvoice = ["ยกเลิกแล้ว", "", "ชำระแล้วบางส่วน", "", "ชำระเงินครบแล้ว"];
let statusOrder = ["ยกเลิกแล้ว", "ยังไม่ได้ทำบัญชี", "ออกใบวางบิลแล้ว", "", "ชำระเงินแล้ว"];

function getStatusInvoice(id)
{
	return statusInvoice[id];
}

function getStatusOrder(id)
{
	return statusOrder[id];
}

function getLocalDateTime(val, full = true) {
	let isMobile = window.screen.width <= 1024 ? true : false; // for mobile
	
	let time = " น.";
	options = {
		year: 'numeric', month: '2-digit', day: '2-digit',
		hour: '2-digit', minute: '2-digit', second: '2-digit',
		hour12: false
	};

	if (isMobile) {
		options = {
			year: 'numeric', month: '2-digit', day: '2-digit'
		};
		time = "";
	}

	// let str = "";
	// if (!isMobile) {
	// 	const d = new Date(val);
	// 	str = new Intl.DateTimeFormat('th-TH', options).format(d) + " น."
	// 	// str = d.toLocaleDateString('th-TH');
	// 	// str += " " + new Intl.DateTimeFormat('th-TH', { timeStyle: 'short', month:'2-digit' }).format(d) + " น."
	// }
	// else {
	// 	const d = new Date(val.substr(0, 10));
	// 	str = d.toLocaleDateString('th-TH');
	// }
	val = val.replace(" ", 'T');
	let d = new Date(val);
	str = new Intl.DateTimeFormat('th-TH', options).format(d) + time;
	return str;
}

function genTimeline(val) {
	divHtml = `<div class="groupStatus">`;
	if(val=="0") {
		divHtml += `<div class="item bg-danger"></div>
					<div class="item"></div>
					<div class="item"></div>
					<div class="item"></div>`;
	}
	else if(val=="1"){
		divHtml += `<div class="item bg-success"></div>
					<div class="item"></div>
					<div class="item"></div>
					<div class="item"></div>`;
	}
	else if(val=="2"){
		divHtml += `<div class="item bg-warning"></div>
					<div class="item bg-success"></div>
					<div class="item"></div>
					<div class="item"></div>`;
	}
	else if(val=="3"){
		divHtml += `<div class="item bg-warning"></div>
					<div class="item bg-warning"></div>
					<div class="item bg-success"></div>
					<div class="item"></div>`;
	}
	else if(val=="4"){
		divHtml += `<div class="item bg-warning"></div>
					<div class="item bg-warning"></div>
					<div class="item bg-warning"></div>
					<div class="item bg-success"></div>`;
	}
	divHtml += `</div>`;

	return divHtml;

	// document.getElementById("status").innerHTML = divHtml;
}

function getBtnIcon(icon = "far fa-edit", text = "แก้ไข") {
	return `<div class="btnIcon"><i class="${icon}"></i></div><div class="btnText"><i class="${icon}"></i> ${text}</div>`;
}

function confirmLogout() {
	event.preventDefault();
	Swal.fire({
		html: "คุณแน่ใจหรือไม่...ที่จะออกจากการทำงานนี้?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#8a8a8a',
		confirmButtonText: 'ใช่! ออกเลย',
		cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = "../logout.php";
		}
	});
}

function sweetAlertError(message, timer = 1500, icon = "error") {
	Swal.fire({
		html: message,
		icon: icon,
		timer: timer,
		confirmButtonText: 'ปิด',
	});
}

function sweetAlertSuccess(message, icon = "success") {
	Swal.fire({
		html: message,
		icon: icon,
		timer: 1500,
		confirmButtonText: 'ปิด',
	});
}

function sweetAlert(message, timer = 1500, icon = "success") {
	Swal.fire({
		html: message,
		icon: icon,
		timer: timer,
		confirmButtonText: 'ปิด',
	});
}

function sweetAlertWarning(message, timer = 1500, icon = "warning") {
	Swal.fire({
		html: message,
		icon: icon,
		timer: timer,
		confirmButtonText: 'ปิด',
		confirmButtonColor: '#8a8a8a',
	});
}

function sweetConfirmSaveWithInput(message, messageBtnConfirm = 'ใช่! บันทึก') {
	return new Promise(function (myResolve, myReject) {
		Swal.fire({
			html: message,
			icon: 'question', // warning,error,success,info,question
			input: 'text',
			inputPlaceholder: 'หมายเหตุ',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#8a8a8a',
			confirmButtonText: messageBtnConfirm,
			cancelButtonText: 'ปิด',
			inputValidator: (value) => {
				if (!value) {
					return 'กรุณาใส่หมายเหตุ!'
				}
			}
		}).then((result) => {
			myResolve({ result: result.isConfirmed, message: result.value });
		});
	});
}

function sweetConfirmWithInput(message, amount, messageBtnConfirm = 'ใช่! บันทึก') {
	return new Promise(function (myResolve, myReject) {
		Swal.fire({
			html: message,
			icon: 'question', // warning,error,success,info,question
			// input: 'text',
			input: 'number',
			inputPlaceholder: 'จำนวนเงิน',
			inputPlaceholder: amount,
			inputValue: amount,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#8a8a8a',
			confirmButtonText: messageBtnConfirm,
			cancelButtonText: 'ปิด',
			// inputAttributes: {
			// 	min: 0,
			// 	max: amount
			// },
			// inputValue: amount
			inputValidator: (value) => {
				if (!value) {
					return 'กรุณาใส่จำนวนเงิน!'
				}
				if (Number(value) > amount) {
					return 'กรุณาใส่จำนวนเงินไม่เกิน ' + addCommas(amount)
				}
			}
		}).then((result) => {
			myResolve({ result: result.isConfirmed, message: result.value });
		});
	});
}

function sweetConfirmDeleteWithInput(message, messageBtnConfirm = 'ใช่! ลบเลย') {
	return new Promise(function (myResolve, myReject) {
		Swal.fire({
			html: message,
			icon: 'warning', // warning,error,success,info,question
			input: 'text',
			inputPlaceholder: 'หมายเหตุ',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#8a8a8a',
			confirmButtonText: messageBtnConfirm,
			cancelButtonText: 'ปิด',
			inputValidator: (value) => {
				if (!value) {
					return 'กรุณาใส่หมายเหตุ!'
				}
			}
		}).then((result) => {
			myResolve({ result: result.isConfirmed, message: result.value });
		});
	});
}

function sweetConfirmSave(message, messageBtnConfirm = 'ใช่! บันทึก') {
	return new Promise(function (myResolve, myReject) {
		Swal.fire({
			html: message,
			icon: 'info', // warning,error,success,info
			content: "input",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#8a8a8a',
			confirmButtonText: messageBtnConfirm,
			cancelButtonText: 'ปิด'
		}).then((result) => {
			myResolve(result.isConfirmed);
		});
	});
}

function sweetConfirmSaveMessage(message, messageBtnConfirm = 'ใช่! บันทึก') {
	return new Promise(function (myResolve, myReject) {
		Swal.fire({
			html: message,
			icon: 'info', // warning,error,success,info
			content: "input",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#8a8a8a',
			confirmButtonText: messageBtnConfirm,
			cancelButtonText: 'ปิด'
		}).then((result) => {
			myResolve(result.isConfirmed);
		});
	});
}

function sweetConfirm(message, messageBtnConfirm = 'ใช่! ลบเลย') {
	return new Promise(function (myResolve, myReject) {
		Swal.fire({
			html: message,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#8a8a8a', //'#d33',
			confirmButtonText: messageBtnConfirm,
			cancelButtonText: 'ปิด'
		}).then((result) => {
			myResolve(result.isConfirmed);
		});
	});
}

function sweetConfirmDelete(message, messageBtnConfirm = 'ใช่! ลบเลย') {
	return new Promise(function (myResolve, myReject) {
		Swal.fire({
			html: message,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#8a8a8a', //'#d33',
			confirmButtonText: messageBtnConfirm,
			cancelButtonText: 'ปิด'
		}).then((result) => {
			myResolve(result.isConfirmed);
		});
	});
}

// function sweetConfirm(message,messageBtnConfirm) {
// 	return new Promise(function (myResolve, myReject) {
// 		Swal.fire({
// 			html: message,
// 			icon: 'warning',
// 			showCancelButton: true,
// 			// confirmButtonColor: '#3085d6',
// 			cancelButtonColor: '#d33',
// 			confirmButtonText: messageBtnConfirm,
// 			cancelButtonText: 'ยกเลิก'
// 		}).then((result) => {
// 			myResolve(result.isConfirmed);
// 		});
// 	});
// }

function changeDarkMode(elem) {
	if (elem.checked) {
		$("body").removeClass("dark-mode");
	}
	else {
		$("body").addClass("dark-mode");
	}
	localStorage.setItem("DarkMode", JSON.stringify(elem.checked))
}

function loadDark() {
	//default is light mode
	let dark = JSON.parse(localStorage.getItem("DarkMode"));
	if (dark === null) {
		localStorage.setItem("DarkMode", JSON.stringify(false))
		$("body").removeClass("dark-mode");
	} else if (dark === false) {
		$("body").addClass("dark-mode");
		$('#darkMode').removeAttr('checked');
		// $('#darkMode').prop('checked', false);
	} else if (dark === true) {
		$("body").removeClass("dark-mode");
		$('#darkMode').prop('checked');
	}
}

function loaderScreen(value) {
	if (value === "show")
		$('#loaderScreen').show();
	else
		$('#loaderScreen').hide();
}

// function addCommas(val) {
// 	str = "" + val;
// 	if (str.length > 3) {
// 		commas = "";
// 		while (str.length > 3) {
// 			commas = "," + str.substr(str.length - 3) + commas;
// 			str = str.substr(0, str.length - 3);
// 		}
// 		commas = str + commas;
// 		return commas;
// 	}
// 	return str;
// }

function addCommas(number) {
	str = Number(number).toLocaleString();
	if (str.indexOf(".") == -1) {
		str += ".00";
	}
	else if (str.indexOf(".") == str.length - 2) {
		123.6
		str += "0";
	}
	return str;
}

loadDark();


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

$("body").removeClass("dark-mode");