<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$pubguid = $vars['pub'];
$groupguid = $vars['group'];
$ts = time();
$token = generate_action_token($ts);

$html = "<span class='tagpubspan'>";
if(check_entity_relationship($groupguid, 'tagby', $pubguid)){
	$html .= <<< EOT
			<a id="$groupguid-$pubguid-tag" style='display:none' class='tagpubBtn' onclick="tag('$groupguid','$pubguid','$ts','$token')">tag as group publication</a>
			<a id="$groupguid-$pubguid-untag" class='tagpubBtn' onclick="untag('$groupguid','$pubguid','$ts','$token')">untag</a>
EOT;
}else{
	$html .= <<< EOT
			<a id="$groupguid-$pubguid-tag" class='tagpubBtn' onclick="tag('$groupguid', '$pubguid', '$ts', '$token')">tag as group publication</a>
			<a id="$groupguid-$pubguid-untag" class='tagpubBtn' style='display:none' onclick="untag('$groupguid','$pubguid','$ts','$token')">untag</a>
EOT;
}

$html .= "</span>";

echo $html;

/*
.tagpubspan{
	float:right;
	margin-left:10px;
}

.tagpubBtn{
        -webkit-border-radius:5px;
        -moz-border-radius:5px;
        -moz-background-clip:border;
        -moz-background-origin:padding;
        -moz-background-inline-policy:continuous;
        color:white;
        background-color:#4690D6;
        cursor:pointer;
        height:auto;
        width:auto;
        line-height:100%;
        font-weight:bold;
        padding:5px;
        float:left;
        margin-left:10px;
        font-size:12px;
}

.tagpubBtn:hover{
	background-color:#0054A7;
        cursor:pointer;
        text-decoration:none;
}
 */