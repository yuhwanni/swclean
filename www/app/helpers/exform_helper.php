<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

function draw_inquiries( $url_act )
{
    $required = '<span style="color: red;">*</span>';
    $html =  '<p class="block_subtitle">[ Product Inquiries ]</p>
        <div>
            <span class="red bold">Enter entitled to receive the following items</span>
            <table class="prd_table" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th class="prd_table_title" colspan="2" scope="row">Contact Information</th>
                </tr>
                <tr>
                    <th scope="row">▶ Name(Buyer)' . $required . ':</th>
                    <td><input type="text" id="buyr_name" name="buyr_name" value=""></td>
                </tr>
                <tr>
                    <th scope="row">▶ Country' . $required . ':</th>
                    <td><input type="text" id="buyr_country" name="buyr_country" value=""></td>
                </tr>
                <tr>
                    <th scope="row">▶ E-Mail' . $required . ':</th>
                    <td><input type="text" id="buyr_email" name="buyr_email" value=""></td>
                </tr>
                <tr>
                    <th scope="row">▶ Job' . $required . ':</th>
                    <td>
                        <label for="buyr_wholesaler" class="label_style"><input type="radio" style="margin:0" id="buyr_wholesaler" name="buyr_kind" value="Wholesaler"> Wholesaler</label>
                        <label for="buyr_retail" class="label_style"><input type="radio" style="margin:0" id="buyr_retail" name="buyr_kind" value="Retail Trader"> Retail Trader</label>
                        <label for="buyr_consumer" class="label_style"><input type="radio" style="margin:0" id="buyr_consumer" name="buyr_kind" value="Consumer"> Consumer</label>
                    </td>
                </tr>
            </table>
        </div>

        <p class="block_subtitle p_gap">[ Inquiries Contents ]' . $required . '</p>
        <div>
            <label for="etc_radio0" class="label_style_common"><input type="radio" style="margin:0" id="etc_radio0" name="etc_kind" value="Smart Solar Lantern"> Product Inquiry ( Smart Solar Lantern )</label><br/>
            <label for="etc_radio1" class="label_style_common"><input type="radio" style="margin:0" id="etc_radio1" name="etc_kind" value="LED Flood Light"> Product Inquiry ( LED Flood Light )</label><br/>
            <label for="etc_radio2" class="label_style_common"><input type="radio" style="margin:0" id="etc_radio2" name="etc_kind" value="Other"> Other</label>
            <table class="prd_table" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                    <col style="width: 10%;">
                </colgroup>
                <tr>
                    <th class="prd_table_title" scope="row">Title' . $required . '</th>
                    <th class="prd_table_title"><input type="text" style="width: 95%;" id="etc_title" name="etc_title" value=""></th>
                </tr>
                <tr>
                    <td>Content' . $required . '</td>
                    <td><textarea style="width:95%;height:150px;" id="etc_content" name="etc_content" ></textarea></td>
                </tr>
            </table>
            <div style="text-align: center; margin-top:20px;">
                <button id="btn_send">Send Mail</button>
            </div>
        </div>';

    $html .= "<script>
            $( document ).ready( function() {
                $( '#btn_send' ).click( function( e ) {
                    e.preventDefault();

                    if ( $( '#buyr_name' ).val()== '' )
                    {
                        alert( 'Please enter Name' );
                        $( '#buyr_name' ).focus();
                        return false;
                    }

                    if ( $( '#buyr_country' ).val()== '' )
                    {
                        alert( 'Please enter Country' );
                        $( '#buyr_country' ).focus();
                        return false;
                    }

                    if ( $( '#buyr_email' ).val()== '' )
                    {
                        alert( 'Please enter Email' );
                        $( '#buyr_email' ).focus();
                        return false;
                    }

                    if ( emailCheck( $( '#buyr_email' ).val() ) == false )
                    {
                        alert( 'Please enter your email address in the format' );
                        $( '#buyr_email' ).focus();
                        return false;
                    }

                    if ( !$( ':input:radio[name=\"buyr_kind\"]:checked' ).val() )
                    {
                        alert( 'Please select a Job' );
                        return false;
                    }

                    if ( !$( ':input:radio[name=\"etc_kind\"]:checked' ).val() )
                    {
                        alert( 'Please select a Inquiries Contents' );
                        return false;
                    }

                    if ( $( '#etc_title' ).val() == '' )
                    {
                        alert( 'Please enter Title' );
                        $( '#etc_title' ).focus();
                        return false;
                    }

                    if ( $( '#etc_content' ).val() == '' )
                    {
                        alert( 'Please enter Content' );
                        $( '#etc_content' ).focus();
                        return false;
                    }

                    $.ajax( {
                        type: 'post',
                        url: '$url_act',
                        data: {
                            name: $( '#buyr_name' ).val(),
                            country: $( '#buyr_country' ).val(),
                            email: $( '#buyr_email' ).val(),
                            job: $( ':radio[name=\"buyr_kind\"]' ).val(),
                            inquiries: $( ':radio[name=\"etc_kind\"]' ).val(),
                            etc_title: $( '#etc_title' ).val(),
                            etc_cont: $( '#etc_content' ).val()
                        },
                        success: function( responseText )
                        {
                            var json = JSON.parse( responseText );

                            if ( json.ret == 1 )
                            {
                                alert( 'Thank you' );
                            }
                            else
                            {
                                alert( 'Wait' );
                            }
                        },
                        error: function( request, status, error )
                        {
                            var msg = '<span style=\"color:red\">code: ' + request.status + '<br>message:<br>' +
                                request.responseText + '<br>error: ' + error + '</span>';
                            alert( msg );
                        }
                    });
                });
            });
        </script>
     ";

    echo $html;
}
