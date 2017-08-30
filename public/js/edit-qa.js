$(".edit-qa").hide()

$(".edit-button").click(function (){
    // console.log($(this.id).parent(".qa"))
    const edit = $("#" + this.id).parent(".qa").find(".edit-qa")
    const display = $("#" + this.id).parent(".qa").find(".display-qa")
    edit.toggle()
    display.toggle()
})
