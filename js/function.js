function create_node(elem){ //建立節點
    let node=document.createElement(elem);
    return node;
}
function add_class(node,class_name){    //增加class
    node=set_attr(node,"class",class_name);
    return node;
}
function add_attribute(node,attr,attr_val){ //增加屬性
    node=set_attr(node,attr,attr_val);
    return node;
}
function add_value(node,value){ //增加value
    node=set_attr(node,"value",value);
    return node;
}
function add_inner(node,inner){ //增加欄內字
    let text=document.createTextNode(inner);
    node.appendChild(text);
    return node;
}
function set_attr(node,attr,attr_val){  //建立屬性
    node.setAttribute(attr,attr_val);
    return node;
}
//加入option
function add_option(node,array){
    let style=$(now_pointer).css(node.attributes.name.nodeValue);
    if(style.match("rgb"))
        style=colorcode_change(style);
    $.each(array,(k,v)=>{
        let option=create_node("option");
        option=add_value(option,v["value"]);
        option=add_inner(option,v["name"]);
        if(style==v["value"])
            option.selected=true;
        node.appendChild(option);
    });
    return node;
}
//色碼轉換
function colorcode_change(color){
    color=color.replace(/[^0-9,]/ig,"");
    color=color.split(",");
    r=parseInt(color[0]).toString(16);
    if(r.length<2)
        r=paddingleft("0",r,2);
    g=parseInt(color[1]).toString(16);
    if(g.length<2)
        g=paddingleft("0",g,2);
    b=parseInt(color[2]).toString(16);
    if(b.length<2)
        b=paddingleft("0",b,2);
    color=`#${r+g+b}`;
    return color;
}
//補位數
function paddingleft(word,str,length){
    let string="";
    for(let i=0;i<length-1;i++){
        string+=word;
    }
    string+=str;
    return string;
}
//--select  <<<<<<<  選項用(start)
//select的option建立機制
function my_option(node){
    let count=node.length;
    let div=create_node("div");
    div=add_class(div,"option_box")
    let k=1;
    let label="",input="",value="",button="",span="";
    label=create_node("label");
    label=add_inner(label,"選項");
    div.appendChild(label);
    if(count>0){
        for(let i=0;i<count;i++){
            input=create_node("input");
            input=add_class(input,"form-control my-1");
            input=add_attribute(input,"name",`option${i+1}`);
            input=add_value(input,$(node).find($(`option[value='option${i+1}']`)).html());
            div.appendChild(input);
        }
    }else{
        input=create_node("input");
        input=add_class(input,"form-control my-1");
        input=add_attribute(input,"name","option1");
        div.appendChild(input);
    }
    return div;
}
//option替換值時的機制
function option_change(node,value,inner){
    let count=node.length;
    if(count>0){
        $.each($(node).children(),(k,v)=>{
            console.log("a:"+value);
            console.log("b:"+v.value);
            console.log($(node).find($(`option[value='${value}']`)).val());
            if(v.value===value)
                $(node).find($(`option[value='${value}']`)).html(inner);
            if($(node).find($(`option[value='${value}']`)).val()===undefined)
                node=create_option(node,value,inner);
        })
    }else
        node=create_option(node,value,inner);
}
//沒有option時建立
function create_option(node,value,inner){
    let option=create_node("option");
    option=add_value(option,value);
    option=add_inner(option,inner);
    node.appendChild(option);
    return node;
}
//--select  <<<<<<<  選項用(end)