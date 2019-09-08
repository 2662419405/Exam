function kaishi(name) {
	var oIn = document.getElementById('input_' + name);
	var con = document.getElementById('ti_' + name);
	if(oIn.value == '隐藏答案') {
		con.style.display = 'none';
		oIn.value = '查看答案';
	} else {
		con.style.display = 'block';
		oIn.value = '隐藏答案';
	}
}

function secBoard(cursel, n) {
	var name = 'two';

	for(var i = 1; i <= n; i++) {
		var menu = document.getElementById(name + i);
		var con = document.getElementById("con_" + name + "_" + i);
		menu.className = i == cursel ? "hover" : "";
		con.style.display = i == cursel ? "block" : "none";

	}
}