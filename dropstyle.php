<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/all.css">
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/allData.js"></script>
<script src="js/function.js"></script>
<style>
*{
    position:relative;
}
.border_lightgray{
    border:1px solid lightgray;
}
.min_h30{
    min-height:30px;
}
.min_h40{
    min-height:40px;
}
.btn:disabled{
    opacity:1;
}
.border_pink{
    border:1px solid pink;
}
.max-w500{
    max-width:500px;
}
.list_style{
    width:90px;
    height:90px;
    display:inline-block;
    margin:3px;
}
.background-limit{
    background-size:100% 100%;
    background-repeat:no-repeat;
}
#target-container div{
    background-size:100% 100%;
    background-repeat:no-repeat;
}
</style>
<div style="width:300px;height:100vh;background:#ddd;position:fixed;top:0;left:0" id="source-container" data-role="drag-drop-container">
    <div style="background-image:url(img/button.png)" class="list_style background-limit" id="drag-source1" draggable="true" value='button'></div>
    <div style="background-image:url(img/image.png)" class="list_style background-limit" id="drag-source2" draggable="true" value='img'></div>
    <div style="background-image:url(img/input.png)" class="list_style background-limit" id="drag-source3" draggable="true" value='text'></div>
    <div style="background-image:url(img/select.png)" class="list_style background-limit" id="drag-source4" draggable="true" value='select'></div>
    <hr>
    <div style="background-image:url(img/full.png)" class="list_style background-limit" id="drag-source10" draggable="true" value='container-fluid'></div>
    <div style="background-image:url(img/container.png)" class="list_style background-limit" id="drag-source11" draggable="true" value='container'></div>
    <div style="background-image:url(img/col_12.png)" class="list_style background-limit" id="drag-source12" draggable="true" value='col-12'></div>
    <div style="background-image:url(img/col_6.png)" class="list_style background-limit" id="drag-source13" draggable="true" value='col-6'></div>
    <div style="background-image:url(img/col_4.png)" class="list_style background-limit" id="drag-source14" draggable="true" value='col-4'></div>
    <div style="background-image:url(img/col_3.png)" class="list_style background-limit" id="drag-source15" draggable="true" value='col-3'></div>
</div>
<div style="width:60vw;min-height:768px;margin:20px 0 0 350px;border:1px solid lightgray;border-radius:10px;padding:10px" id="target-container" data-role="drag-drop-container">
    <div style="width:100%;height:100%"></div>
</div>
<div style="width:300px;height:500px;position:fixed;right:20px;background:black;top:10px;color:white;border-radius:10px;padding:10px;color:white;overflow:auto" id="content_style">請點擊區塊來顯示控制項</div>
<script>
let sourceContainerId = "";
let init=["Blue","Gray","Green","Red","Yellow","Lightblue","Lightgray","Black"];
let now_pointer="";

let dragSources = document.querySelectorAll('[draggable="true"]');
dragSources.forEach(dragSource => {
    dragSource.addEventListener("dragstart", dragStart);
    dragSource.addEventListener("dragend", dragEnd);
});

function dragStart(e) {
    this.classList.add("dragging");
    e.dataTransfer.setData("text/plain", e.target.id);
    sourceContainerId = this.parentElement.id;
}

function dragEnd(e) {
    this.classList.remove("dragging");
}

// Allow multiple dropped targets
let dropTargets = document.querySelectorAll(
    '[data-role="drag-drop-container"]'
);
dropTargets.forEach(dropTarget => {
    dropTarget.addEventListener("drop", dropped);
    dropTarget.addEventListener("dragenter", cancelDefault);
    dropTarget.addEventListener("dragover", dragOver);
    dropTarget.addEventListener("dragleave", dragLeave);
});

function dropped(e) {
    // execute function only when target container is different from source container
    if (this.id !== sourceContainerId) {
        cancelDefault(e);
        let id = e.dataTransfer.getData("text/plain");
        // e.target.appendChild(document.querySelector("#" + id));
        let result=element_mode($(`#${id}`).attr("value"));
        e.target.appendChild(result);
        this.classList.remove("hover");
    }
}

function dragOver(e) {
    cancelDefault(e);
    this.classList.add("hover");
}

function dragLeave(e) {
    this.classList.remove("hover");
}

function cancelDefault(e) {
    e.preventDefault();
    e.stopPropagation();
    return false;
}
//條件補齊
function element_mode(elem){
    let elem_model="";
    elem_model=new_node(allData[elem]["element"],allData[elem]["class"],allData[elem]["value"],allData[elem]["inner_value"],allData[elem]["attribute"],allData[elem]["attr_value"],allData[elem]["col_chk"],allData[elem]["role"]);
    return elem_model;
}
//建立節點(element,class,value,attribute,attribute_value,col_check)
function new_node(elem,class_name=null,val=null,inner=null,attr=null,attr_val=null,col_chk=null,role){
    let node="";
    if(col_chk!==null){
        let parent_node=create_node("div");
        parent_node=add_class(parent_node,"row");
        if(col_chk>=1){
            for(let i=0;i<col_chk;i++){
                node=create_node(elem);
                node=add_class(node,class_name);
                node=add_attribute(node,"role",role);
                parent_node.appendChild(node);
            }
        }else if(col_chk==0){
            parent_node=add_class(parent_node,class_name);
            parent_node=add_attribute(parent_node,"role",role);
        }
        node=parent_node;
    }else{
        node=create_node(elem);
        if(class_name!==null)  
            node=add_class(node,class_name);
        if(val!==null)
            node=add_value(node,val);
        if(inner!==null)
            node=add_inner(node,inner);
        if(attr!==null)   
            node=add_attribute(node,attr,attr_val);
        node=add_attribute(node,"role",role);
    }
    return node;
}
//控制面板
function control_page(node){
    $("#content_style").html("");
    let node_style=window.getComputedStyle(node, null);
    let table_node=create_node("table");
    console.log(node_style);
    table_node=add_class(table_node,"w-100 text-white");
    let tr_node=create_node("tr");
    let td_node=create_node("td");
    let h5="";
    let node_name=node.attributes.role;
    if(node_name!=undefined){
        if(allData[node_name.nodeValue]["border"]){
            h5=create_node("h5");
            h5=add_inner(h5,"框線樣式");
            td_node.appendChild(h5);
            if(allData[node_name.nodeValue]["border-width"])
                td_node.appendChild(create_form("框線大小","input","border-width",node_style,false));
            if(allData[node_name.nodeValue]["border-style"])
                td_node.appendChild(create_form("框線樣式","select","border-style",node_style,true));
            if(allData[node_name.nodeValue]["border-color"])
                td_node.appendChild(create_form("框線顏色","select","border-color",node_style,true));
        }
        if(allData[node_name.nodeValue]["background"]){
            h5=create_node("h5");
            h5=add_inner(h5,"背景樣式");
            td_node.appendChild(h5);
            if(allData[node_name.nodeValue]["background-color"])
                td_node.appendChild(create_form("背景顏色","select","background-color",node_style,true));
            if(allData[node_name.nodeValue]["background-image"])
                td_node.appendChild(create_form("背景圖片","input","background-image",node_style,false));
        }
        if(allData[node_name.nodeValue]["src"])
            td_node.appendChild(create_form("圖片連結","input","src",node_style));
        if(allData[node_name.nodeValue]["inner"])
            td_node.appendChild(create_form("值","input","innerHTML",node_style));
        tr_node.appendChild(td_node);
        table_node.appendChild(tr_node);
        $("#content_style").append(table_node);
        let del_btn=create_node("button");
        del_btn=add_class(del_btn,"btn btn-danger btn-block");
        del_btn=add_attribute(del_btn,"id","del_btn");
        del_btn=add_inner(del_btn,"刪除");
        let div=create_node("div");
        div=add_class(div,"my-2");
        div.appendChild(del_btn)
        $("#content_style").append(div);
    }
}
//建立控制面板欄位
function create_form(label_name,elem,style_name,node_style,select){
    let div=create_node("div");
    let label=create_node("label");
    label=add_inner(label,label_name);
    let element=create_node(elem);
    element=add_class(element,"form-control");
    element=add_attribute(element,"name",style_name);
    if(select){
        element=add_option(element,optionData[style_name]);
    }else{
        if(style_name==="border-width")
            element=add_value(element,Math.round(node_style.getPropertyValue(style_name).replace(/[^0-9.]/ig,"")));
        if(style_name==="background-image"||style_name==="src"){
            element=add_attribute(element,"type","file");
            element=add_attribute(element,"accept","image/*");
        }
        if(style_name==="innerHTML")
            element=add_value(element,now_pointer.innerHTML);
    }
    div.appendChild(label);
    div.appendChild(element);
    return div;
}
//點擊判定
$(document).on("change","select",(e)=>{
    let value=$(e.target).find(":selected").val();
    let sign=$(e.target).attr("name");
    now_pointer.style.setProperty(sign,value);
})
$(document).on("change","input",(e)=>{
    let value=$(e.target).val();
    let txt_name=e.target.attributes.name.nodeValue;
    if(e.target.files && e.target.files[0]){
        let reader=new FileReader();
        reader.onload=(e)=>{
            if(txt_name==="src")
                $(now_pointer).attr('src',e.target.result);
            if(txt_name==="background-image")
                $(now_pointer).css("background-image",`url(${e.target.result})`);
        }
        reader.readAsDataURL(e.target.files[0]);
    }
    let sign=$(e.target).attr("name");
    if(sign==="innerHTML"){
        now_pointer.innerHTML=value;
    }else{
        now_pointer.style.setProperty(sign,`${value}px`);
    }
    
})
$(document).on("click","#target-container>div",function(e){
    now_pointer=e.target;
    control_page(e.target);
})
$(document).on("click","#del_btn",(e)=>{
    now_pointer.parentNode.removeChild(now_pointer);
    $("#content_style").html("");
})
</script>