<?

// If the user agent is defined and is not a known bot
if (!empty($_SERVER["HTTP_USER_AGENT"]) && !preg_match("/rambler|abacho|acoi|accona|aspseek|altavista|estyle|scrubby|lycos|geona|ia_archiver|alexa|sogou|skype|facebook|twitter|pinterest|linkedin|naver|bing|google|yahoo|duckduckgo|yandex|baidu|teoma|xing|java\/1.7.0_45|bot|crawl|slurp|spider|mediapartners|\sask\s|\saol\s/i", $_SERVER["HTTP_USER_AGENT"])) {
	$ip = $_SERVER["REMOTE_ADDR"];
	$credentials = base64_encode("113668:Tnkd9VkhxMTBApYi");
	$context = stream_context_create(["http" => ["header" => "Authorization: Basic $credentials"]]);
	$response = json_decode(file_get_contents("https://geoip.maxmind.com/geoip/v2.1/country/$ip", false, $context));
	$country = strtolower($response->country->iso_code);
} else {
	$country = "us";
}

echo $country;

?>