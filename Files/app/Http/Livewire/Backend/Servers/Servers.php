<?php

namespace App\Http\Livewire\Backend\Servers;

use App\Models\Server;
use Livewire\Component;
use Livewire\WithFileUploads;

class Servers extends Component {

    use WithFileUploads;

    public $servers, $server, $addServer, $updateServer, $import;
    public $countries = array("AF" => "Afghanistan", "AX" => "Aland Islands", "AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua and Barbuda", "AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria", "AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados", "BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda", "BT" => "Bhutan", "BO" => "Bolivia", "BQ" => "Bonaire", "BA" => "Bosnia and Herzegovina", "BW" => "Botswana", "BV" => "Bouvet Island", "BR" => "Brazil", "IO" => "British Indian Ocean Territory", "BN" => "Brunei Darussalam", "BG" => "Bulgaria", "BF" => "Burkina Faso", "BI" => "Burundi", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada", "CV" => "Cape Verde", "KY" => "Cayman Islands", "CF" => "Central African Republic", "TD" => "Chad", "CL" => "Chile", "CN" => "China", "CX" => "Christmas Island", "CC" => "Cocos (Keeling) Islands", "CO" => "Colombia", "KM" => "Comoros", "CD" => "Congo", "CG" => "Congo", "CK" => "Cook Islands", "CR" => "Costa Rica", "HR" => "Croatia", "CU" => "Cuba", "CY" => "Cyprus", "CZ" => "Czech Republic", "DK" => "Denmark", "DJ" => "Djibouti", "DM" => "Dominica", "DO" => "Dominican Republic", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea", "ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FK" => "Falkland Islands (Malvinas)", "FO" => "Faroe Islands", "FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia", "TF" => "French Southern Territories", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany", "GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea", "GW" => "Guinea-Bissau", "GY" => "Guyana", "HT" => "Haiti", "VA" => "Holy See (Vatican City State)", "HN" => "Honduras", "HK" => "Hong Kong", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India", "ID" => "Indonesia", "IR" => "Iran", "IQ" => "Iraq", "IE" => "Ireland", "IM" => "Isle of Man", "IL" => "Israel", "IT" => "Italy", "JM" => "Jamaica", "JP" => "Japan", "JE" => "Jersey", "JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KI" => "Kiribati", "KP" => "Korea", "KR" => "Korea", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LA" => "Lao Peoples Democratic Republic", "LV" => "Latvia", "LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libya", "LI" => "Liechtenstein", "LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macao", "MK" => "Macedonia", "MG" => "Madagascar", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "YT" => "Mayotte", "MX" => "Mexico", "FM" => "Micronesia", "MD" => "Moldova", "MC" => "Monaco", "MN" => "Mongolia", "ME" => "Montenegro", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "MM" => "Myanmar", "NA" => "Namibia", "NR" => "Nauru", "NP" => "Nepal", "AN" => "Netherlands Antilles", "NL" => "Netherlands", "NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria", "NU" => "Niue", "NF" => "Norfolk Island", "MP" => "Northern Mariana Islands", "NO" => "Norway", "OM" => "Oman", "PK" => "Pakistan", "PW" => "Palau", "PS" => "Palestine", "PA" => "Panama", "PG" => "Papua New Guinea", "PY" => "Paraguay", "PE" => "Peru", "PH" => "Philippines", "PN" => "Pitcairn", "PL" => "Poland", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RO" => "Romania", "RU" => "Russian Federation", "RW" => "Rwanda", "BL" => "Saint Barth", "SH" => "Saint Helena", "KN" => "Saint Kitts And Nevis", "LC" => "Saint Lucia", "MF" => "Saint Martin", "PM" => "Saint Pierre And Miquelon", "VC" => "Saint Vincent And The Grenadines", "WS" => "Samoa", "SM" => "San Marino", "ST" => "Sao Tome and Principe", "SA" => "Saudi Arabia", "SN" => "Senegal", "RS" => "Serbia", "SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SX" => "Sint Maarten", "SK" => "Slovakia", "SI" => "Slovenia", "SB" => "Solomon Islands", "SO" => "Somalia", "ZA" => "South Africa", "SS" => "South Sudan", "ES" => "Spain", "LK" => "Sri Lanka", "SD" => "Sudan", "SR" => "Suriname", "SJ" => "Svalbard And Jan Mayen", "SZ" => "Swaziland", "SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syrian Arab Republic", "TW" => "Taiwan", "TJ" => "Tajikistan", "TZ" => "Tanzania", "TH" => "Thailand", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau", "TO" => "Tonga", "TT" => "Trinidad and Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TM" => "Turkmenistan", "TC" => "Turks and Caicos Islands", "TV" => "Tuvalu", "UG" => "Uganda", "UA" => "Ukraine", "AE" => "United Arab Emirates", "GB" => "United Kingdom", "UM" => "United States Minor Outlying Islands", "US" => "United States", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VU" => "Vanuatu", "VE" => "Venezuela", "VN" => "Vietnam", "VG" => "Virgin Islands", "VI" => "Virgin Islands", "WF" => "Wallis and Futuna", "EH" => "Western Sahara", "YE" => "Yemen", "ZM" => "Zambia", "ZW" => "Zimbabwe");

    public function mount() {
        $this->updateServers();
        $this->clearServerObject();
        $this->addServer = false;
        $this->updateServer = false;
    }

    public function updateServers() {
        $this->servers = Server::get();
    }

    public function clearAddUpdate() {
        $this->addServer = false;
        $this->updateServer = false;
        $this->clearServerObject();
    }

    public function clearServerObject() {
        $this->server = [
            'name' => '',
            'url' => '',
            'lat' => '',
            'long' => '',
            'country' => '',
            'is_active' => true
        ];
    }

    public function add() {
        $this->validate(
            [
                'server.name' => 'required',
                'server.url' => 'required',
                'server.lat' => 'required',
                'server.long' => 'required',
                'server.country' => 'required'
            ],
            [
                'server.name.required' => 'Server Name is Required',
                'server.url.required' => 'Please enter either URL or IP address of DNS Server',
                'server.lat.required' => 'Server location latitude is Required',
                'server.long.required' => 'Server location longitude is Required',
                'server.country.required' => 'Server location country is Required',
            ]
        );
        Server::create($this->server);
        $this->emit('saved');
        $this->updateServers();
        $this->clearAddUpdate();
    }

    public function showUpdate($server) {
        $this->updateServer = true;
        $this->server = $server;
    }

    public function update() {
        $this->validate(
            [
                'server.name' => 'required',
                'server.url' => 'required',
                'server.lat' => 'required',
                'server.long' => 'required',
                'server.country' => 'required'
            ],
            [
                'server.name.required' => 'Server Name is Required',
                'server.url.required' => 'Please enter either URL or IP address of DNS Server',
                'server.lat.required' => 'Server location latitude is Required',
                'server.long.required' => 'Server location longitude is Required',
                'server.country.required' => 'Server location country is Required',
            ]
        );
        $server = Server::findOrFail($this->server['id']);
        $server->fill($this->server);
        $server->save();
        $this->emit('saved');
    }

    public function delete($server) {
        $server = Server::findOrFail($server['id']);
        $server->delete();
        $this->updateServers();
    }

    public function toggle($server_id) {
        $server = Server::find($server_id);
        $server->is_active = !$server->is_active;
        $server->save();
        $this->updateServers();
    }

    public function updatedImport() {
        $file = $this->import->store('import');
        $servers = json_decode($this->csvToJson(storage_path('app') . '/' . $file), true);
        foreach ($servers as $server) {
            Server::create($server);
        }
        $this->updateServers();
    }

    public function deleteAll() {
        Server::whereNotNull('id')->delete();
        $this->updateServers();
    }

    public function render() {
        return view('backend.servers.servers');
    }

    private function csvToJson($fname) {
        if (!($fp = fopen($fname, 'r'))) {
            die("Can't open file...");
        }
        $key = fgetcsv($fp, "1024", ",");
        $json = array();
        while ($row = fgetcsv($fp, "1024", ",")) {
            $json[] = array_combine($key, $row);
        }
        fclose($fp);
        return json_encode($json);
    }
}
