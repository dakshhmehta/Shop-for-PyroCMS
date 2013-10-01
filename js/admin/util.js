
/**
 * This is for the product options in admin/product/edit [options tab]
 *
 */

function build_li_option_html( assign_id, option_name)
{

    content =   '<li id="option_assign_' + assign_id + '">';
    content +=  '   <label></label>';
    content +=  '   <div class="input">';
    content +=  '       <span>'+ option_name +'</span>';
    content +=  '       <span id="OptionButtons" style="float:right">';
    content +=  '           <a href="#" class="img_up img_icon" data-option-id="' + assign_id + '"></a>';
    content +=  '           <a href="#" class="img_down img_icon" data-option-id="' + assign_id + '"></a>';
    content +=  '           <a href="#" class="img_delete img_icon remove" data-option-id="' + assign_id + '"></a>';
    content +=  '       </span>';
    content +=  '   </div>';
    content +=  '</li>';
    
    return content;

}

function build_li_attribute_html( label, value, id )
{

    content =  '<li id="item_'+ id +'">';
    content += '   <label>'+label+'</label>';
    content += '   <div class="input">';
    content += '	 ' + value+ '';                                   
    content += '	 <a class="img_delete img_icon remove" data-id="' + id + '" data-row="item_' + id + '"></a>';
    content += '   </div>'
    content += '</li>';
            
    return content;
}