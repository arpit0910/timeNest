<?php

$svg = '<svg viewBox="0 0 100 120" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">';
$svg .= '<g opacity="0.9">';

// Center whorl
$svg .= '<path d="M45,60 C45,55 55,55 55,60 C55,66 42,66 42,60 C42,52 58,52 58,60 C58,70 39,70 39,60 C39,49 61,49 61,60 C61,74 36,74 36,60 C36,46 64,46 64,60 C64,78 33,78 33,60 C33,43 67,43 67,60" />';

// Additional surrounding arches and loops
$svg .= '<path d="M30,60 C30,39 70,39 70,60 C70,82 30,82 30,86" />';
$svg .= '<path d="M27,60 C27,36 73,36 73,60 C73,85 27,85 27,90" />';
$svg .= '<path d="M24,60 C24,33 76,33 76,60 C76,88 24,88 24,94" />';
$svg .= '<path d="M21,60 C21,30 79,30 79,60 C79,92 21,92 21,98" />';
$svg .= '<path d="M18,60 C18,27 82,27 82,60 C82,96 18,96 18,102" />';
$svg .= '<path d="M15,60 C15,24 85,24 85,60 C85,100 15,100 15,106" />';

// Add some broken lines and bifurcations for realism
$svg .= '<path d="M12,60 C12,21 88,21 88,60 C88,70 86,80 82,90" />';
$svg .= '<path d="M12,70 C12,85 15,95 20,105" />';
$svg .= '<path d="M9,60 C9,18 91,18 91,60 C91,65 90,75 87,85" />';
$svg .= '<path d="M48,45 C50,45 52,45 52,45" />';
$svg .= '<path d="M44,72 C48,74 52,74 56,72" />';
$svg .= '<path d="M38,38 C45,34 55,34 62,38" />';
$svg .= '<path d="M32,96 C38,102 45,105 50,105 C55,105 62,102 68,96" />';
$svg .= '<path d="M35,102 C40,108 45,112 50,112 C55,112 60,108 65,102" />';

$svg .= '</g></svg>';

file_put_contents('e:/timeNest/public/images/mockups/fingerprint.svg', $svg);
echo "SVG created.";
