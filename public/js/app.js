!function(e){var t={};function n(o){if(t[o])return t[o].exports;var i=t[o]={i:o,l:!1,exports:{}};return e[o].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(o,i,function(t){return e[t]}.bind(null,i));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=0)}([function(e,t,n){n(1),e.exports=n(2)},function(e,t){var n;(n=jQuery)(document).ready(function(){var e=n(".product-quick-add"),t=n(".cart-item-remove"),o=n("#product-media-preview").find(".product-media-remove"),i=n("#product-media-upload"),r=n("#specifications"),c=n("#mass-action");n(".message-close").css("display","inline-block").click(function(){n(".flash-message").fadeOut(500)}),n("#mass-select").on("click",function(){n(this).is(":checked")?n(".entity-select").each(function(){n(this).prop("checked",!0)}):n(".entity-select").each(function(){n(this).prop("checked",!1)})}),n("#filters-clear").on("click",function(){var e;e=n("#table-search"),n(e).find(":input").each(function(){n(this).val("")}),n(e).find("select").each(function(){n(this).selectedIndex=0})}),n(".content-section-toggle").on("click",function(){n("i",this).toggleClass("fa-angle-up fa-angle-down"),n(this).parent().find(".content-container").slideToggle()}),n("#category-parent").on("change",function(){"1"===n(this).val()?n("#category-parent-id").hide():n("#category-parent-id").show()}),n("#entity-delete").on("click",function(){return confirm("Delete this?")}),confirmAction=function(e){for(var t=Object.values(e),o=function(){var e=r[i];if(n.isEmptyObject(e.element))return"continue";e.element.on("submit",function(){if(c.val()===e.id){var t=n(".entity-select:checked").length;if(t>0){var o=e.action.charAt(0).toUpperCase()+e.action.slice(1);return confirm(o+" "+t+" "+e.entity+"?")}}})},i=0,r=t;i<r.length;i++)o()};var a={product:{element:n("#catalog-form"),id:"3",action:"delete",entity:"products"},category:{element:n("#categories-form"),id:"3",action:"delete",entity:"categories"},specification:{element:n("#specifications-form"),id:"1",action:"delete",entity:"property groups"},property:{element:n("#properties-form"),id:"1",action:"delete",entity:"properties"},user:{element:n("#users-form"),id:"2",action:"disable",entity:"users"}};confirmAction(a),n(".checkout-delivery-storage, .checkout-delivery-address").on("click",function(){var e=n(this).find('input[type="checkbox"]');e.prop("checked",!0),n('input[type="checkbox"]').not(e).prop("checked",!1)}),n("#checkout-confirm-form").one("submit",function(){n(this).find("#order-submit").addClass("disabled").attr("onclick","return false;")}),n(".dropdown-trigger").on("click",function(){var e;e=n(this),n(".dropdown-content").hide(),n(e).find(".dropdown-content").show()}),n(document).on("click",function(e){n(e.target).closest(".dropdown-content").length||n(e.target).closest(".dropdown-trigger").length||n(".dropdown-content").hide()}),n(".product-media-item > img").magnificPopup({type:"image",gallery:{enabled:!0},callbacks:{elementParse:function(e){e.src=e.el.attr("src")}}}),i.on("change",function(){for(var e=n("#product-media-preview"),t=n(this)[0].files,o=0;o<t.length;o++){var i=t[o].name,r=i.substring(i.lastIndexOf(".")+1).toLowerCase();if("jpg"==r||"jpeg"==r||"png"==r||"gif"==r)if("undefined"!=typeof FileReader){e.find(".media-item.new").remove();var c=new FileReader;c.onload=function(t){n("<div />",{class:"media-item new"}).append(n("<img />",{src:t.target.result,class:"img-responsive"})).appendTo(e)},c.readAsDataURL(t[o])}else console.log("This browser does not support FileReader");else console.log("Invalid media type")}}),n.ajaxSetup({headers:{"X-CSRF-TOKEN":n('meta[name="csrf-token"]').attr("content")}}),n("#category-select").on("change",function(){n.ajax({type:"GET",url:"/admin/product/categories",data:{selectFieldValue:n(this).val()},success:function(e){r.html(e)},error:function(){r.empty()}})}),e.on("click",function(){n.ajax({type:"POST",url:"/cart/add",data:{productId:n(this).val()},dataType:"json",success:function(e){n("#navbar-cart-items").html(e)},error:function(e){console.log("error: "+e)}})}),t.on("click",function(){n.ajax({type:"POST",url:"/cart/remove",data:{productId:n(this).val()},dataType:"json",success:function(e){window.location.href=e.redirectUrl},error:function(e){console.log("error: "+e)}})}),o.on("click",function(e){var t=n(this);e.preventDefault(),t.addClass("disabled"),n.ajax({type:"POST",url:"/admin/product/update",data:{mediaId:t.data("id"),productId:t.data("product_id")},dataType:"json",success:function(){t.parent().remove()},error:function(e){t.removeClass("disabled"),console.log("error: "+e)}})})})},function(e,t){}]);