<table align="center" width="650" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; color: #4A4E5E; font-family: '微软雅黑', 'Microsoft Yahei', '宋体', 'simsun', '黑体', Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 29px; max-width: 600px; padding-top: 0px">
    <tbody>
        <tr>
            <td width="650" height="165">
                <img border="0" height="144" width="650" src="{{ $logo }}">
            </td>
        </tr>
        <tr>
            <td>
                <table width="650" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td width="55"></td>
                            <td width="540">
                                <table width="540" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr height="32">
                                            <td width="540" height="32"></td>
                                        </tr>
                                        <tr height="61">
                                            <td>
                                                <p style="font-family: '微软雅黑', 'Microsoft Yahei', '宋体', 'simsun', '黑体', Arial, sans-serif !important;"><span style="border-bottom-width: 1px; border-bottom-style: dashed; border-bottom-color: rgb(204, 204, 204); z-index: 1; position: static;color:black;font-weight:600;" t="7" onclick="return false;" data="229270575" isout="1">已备份 <span style="color:red;">{{ $file_name }}</span></span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr height="62">
                                            <td>
                                                <p style="font-family: '微软雅黑', 'Microsoft Yahei', '宋体', 'simsun', '黑体', Arial, sans-serif !important;">
                                                    <a href="{:config('now_host')}" style="font-weight:bolder;color:#4d82dc;text-decoration:none;" target="_blank"><span style="color:#ad91e1;">来自</span> {{ $hostname }}</a>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr height="20">
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="55"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>