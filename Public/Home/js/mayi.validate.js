/**
 * 校验港澳通行证
 * @param value
 * @returns
 */
function isHKMacao(value) {
	var re = /^[HMhm]{1}([0-9]{10}|[0-9]{8})$/;
	return re.test(value);
}

/**
 * // 台湾通行证验证
 * @param value
 * @returns
 */
function isTaiwan(value) {
	var re1 = /^[0-9]{8}$/;
	var re2 = /^[0-9]{10}$/;
	//return (re1.test(value) || re2.test(value));
	return true;
}
/**
 * 护照验证
 * @param value
 * @returns
 */
function isPassport(value) {
	 var re1 = /^[a-zA-Z]{5,17}$/;
	 var re2 = /^[a-zA-Z0-9]{5,17}$/;
	return (re1.test(value) || re2.test(value));
}
/**
 * 军官证
 * @param value
 * @returns
 */
function ismilitaryID(value) {
	 var re = /^[\u4e00-\u9fa5][\u4e00-\u9fa50-9]+$/ 
	 return re.test(value);
}