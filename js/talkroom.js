 var ws, name, client_list = {};
            connect();
            // 连接服务端
function connect() {
    // 创建websocket
    ws = new WebSocket("ws://" + document.domain + ":7272");
    // 当socket连接打开时，输入用户名
    ws.onopen = onopen;
    // 当有消息时根据消息类型显示不同信息
    ws.onmessage = onmessage;
    ws.onclose = function () {
        console.log("连接关闭，定时重连");
        connect();
    };
    ws.onerror = function () {
        console.log("出现错误");
    };
}
var talk_room_isopen = true;
document.oncontextmenu = function(){
window.event.returnValue=false; //將滑鼠右鍵事件取消
}
function onopen()
    {

        // 登录
        var login_data = '{"type":"login","client_name":"'+userid+'","room_id":"1"}';
        console.log("websocket握手成功，发送登录数据:"+login_data);
        ws.send(login_data);
        $('body').append('<div class="small_box" style="height:200px;width:15%;background:white"><span id="talk_title">互助聊天室</span><button id="need_help">需要幫助</button></div>');
        if(localStorage.getItem("talk")!=null){
		$('#need_help').remove();
		    $('.small_box').append('<span id="talk_part" style=""><div style="height:60%;width:100%;border:1px solid black;background:white;overflow:hidden; overflow-y: scroll" id="get_msg"></div><input id="send_msg_txt"><button id="send_msg">送出</button></span>');
		$('#get_msg').append(localStorage.getItem("talk"));
 $('#send_msg').click(function(){
                ws.send('{"type":"say","room_id":"1","to_client_id":"all","content":"talk@'+username+"說："+$('#send_msg_txt').val()+'"}');
            });
	}
        $('#talk_title').click(function(){
            if(talk_room_isopen){
                 $('#talk_part').toggle();
                $('.small_box').animate({"height":"20px"});
            }else{
                 $('#talk_part').toggle();
                $('.small_box').animate({"height":"200px"});
            }
           
            talk_room_isopen = !talk_room_isopen;
        });
        $('#need_help').click(function(){
           $(this).remove();
            $('.small_box').append('<span id="talk_part" style=""><div style="height:60%;width:100%;border:1px solid black;background:white;overflow:hidden; overflow-y: scroll" id="get_msg"></div><input id="send_msg_txt"><button id="send_msg">送出</button></span>');
            $('#send_msg').click(function(){
                ws.send('{"type":"say","room_id":"1","to_client_id":"all","content":"talk@'+username+"說："+$('#send_msg_txt').val()+'"}');
            });
        });
    }
$(window).on('beforeunload', function(){
         console.log("beforeUnload event!");
    localStorage.removeItem("talk");
     });
//$(window).unload(function(){
//    // Do Something
//localStorage.removeItem("talk");
//	alert("close");
//});
// 服务端发来消息时
function onmessage(e) {
    console.log(e.data);
    var data = eval("(" + e.data + ")");
    switch (data['type']) {
        // 服务端ping客户端

    case 'say':
            var temp = data['content'].split('@');
           if(temp[0]=="order"){
                $('#'+temp[1]+'state').html('<span style="color:gray">已預約</span>');
                $('#'+temp[1]+'bro').remove();
                $('#'+temp[1]+'showtxt').replaceWith('<div id="obj'+temp[1]+'showtxt" class="obj_name selection">已被預約</div>')
                if(window.location.href.indexOf('rented_history.php')>-1){
                    location.href="rented_history.php";
                }
           }else if(temp[0]=="acept"){
               //alert(temp[2]);
//               if(userid==temp[2]){
//                     const toast = new siiimpleToast();
//               toast.alert("您的"+temp[1]+"預約已被同意");
//               }
             
           }else if(temp[0]=="return"){
                $('#'+temp[1]+'state').html('<span style="color:green">空閑中</span>');
               //alert();
               if(window.location.href.indexOf('rented_history.php')>-1){

                }else{
                      $('#'+temp[1]).append('<div id="'+temp[1]+'bro" class="objbtn" onclick="location.href=\'rented.php?data='+temp[2]+'">租借</div>');
                }

                $('#'+temp[1]+'showtxt').replaceWith('<div id="obj'+temp[1]+'showtxt" class="obj_name selection">空閑中</div>')
           }else if(temp[0]=="bulletin"){

               if(window.location.href.indexOf('index.php')>-1){
                     location.href='';
                }


           }else if(temp[0]=="repay"){
               $('#'+temp[1]+'state').html('<span style="color:gray">已報修</span>');
                $('#'+temp[1]+'bro').remove();
                $('#'+temp[1]+'showtxt').replaceWith('<div id="obj'+temp[1]+'showtxt" class="obj_name selection">已報修</div>')
                if(window.location.href.indexOf('rented_history.php')){
                    location.href="rented_history.php";
                }
           }else if(temp[0]=="talk"){

		var a = localStorage.getItem("talk");
		
               var aaa = temp[1].split('：');
               
               if(aaa[0].indexOf(username)>-1){
			
			if(localStorage.getItem("talk")==null){
			localStorage.setItem("talk", '<p style="border-bottom:1px solid black; text-align: right">'+aaa[1]+'</p>');
			}else{localStorage.setItem("talk", a+'<p style="border-bottom:1px solid black; text-align: right">'+aaa[1]+'</p>');}
               	 $('#get_msg').append('<p style="border-bottom:1px solid black; text-align: right">'+aaa[1]+'</p>');
               }else{
			if(localStorage.getItem("talk")==null){
			localStorage.setItem("talk", '<p style="border-bottom:1px solid black; text-align: left">'+temp[1]+'</p>');
			}else{localStorage.setItem("talk", a+'<p style="border-bottom:1px solid black; text-align: left">'+temp[1]+'</p>');}
		
                 $('#get_msg').append('<p style="border-bottom:1px solid black; text-align: left">'+temp[1]+'</p>');
               }
             
           }

        break;


    }
}





