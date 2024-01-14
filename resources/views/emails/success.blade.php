<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;"
    id="bodyTable">
    <tbody>
        <tr>
            <td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
                <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" style="width:800px;" width="800">
                <tr>
                    <td align="center" valign="top">
            <![endif]-->

                <table border="0" cellpadding="0" cellspacing="0" style="max-width:800px;" width="100%"
                    class="wrapperWebview">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="middle"
                                                style="padding-top: 30px; padding-bottom: 30px;" class="emailLogo">
                                                <a href="{{ route('client.home') }}"
                                                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:19px;font-weight:bold;text-decoration:none;display:inline-block"
                                                    target="_blank">
                                                    {{ hwa_app_name() }}
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" style="max-width:800px;" width="100%">
                    <thead>
                        <td>
                            STT
                        </td>
                        <td>
                            Sản phẩm
                        </td>
                        <td>
                            Giá tiền
                        </td>
                        <td>
                            Số lương
                        </td>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $item['product']['name'] }}

                                </td>
                                <td>
                                    {{ $item['product']['price'] }}
                                </td>
                                <td>
                                    {{ $item['quantity'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" style="max-width:800px;" width="100%"
                    class="wrapperBody">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0"
                                    style="background-color:#FFFFFF;border-color:#E5E5E5;border-style:solid;border-radius: 8px;"
                                    width="100%" class="tableCard">
                                    <tbody>
                                        <tr>
                                            <td height="3"
                                                style="background-color:#2a3042;font-size:1px;line-height:3px;"
                                                class="topBorder">&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top"
                                                style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;"
                                                class="mainTitle">
                                                <h4
                                                    style="color:#495057;font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:16px;font-weight:600;line-height:1.5;text-align:left!important; margin: 30px 0 30px;">
                                                </h4>
                                                <p class="text"
                                                    style="color: #868e96; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; font-style:normal; letter-spacing:normal; line-height: 1.5; text-transform:none; text-align:left; padding:0; margin:0 0 15px;">
                                                    Tổng tiền: {{ $total }}
                                                    vnđ
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top"
                                                style="padding-left:20px;padding-right:20px;"
                                                class="containtTable ui-sortable">
                                                <table width="100%" cellpadding="0" cellspacing="0"
                                                    role="presentation"
                                                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-top:1px solid #e8e5ef;margin-top:25px;padding-top:25px">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top"
                                                                style="padding-bottom: 20px;" class="description">
                                                                <p class="text"
                                                                    style="color: #868e96; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; font-style:normal; letter-spacing:normal; line-height: 1.5; text-transform:none; text-align:left; padding:0; margin:0">
                                                                    <span>Thân ái,<br />
                                                                        {{ hwa_app_name() }}</span>
                                                                </p>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                        </tr>

                                    </tbody>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
                                    <tbody>
                                        <tr>
                                            <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                    </tbody>
                </table>


                <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
            </td>
        </tr>
    </tbody>
</table>
