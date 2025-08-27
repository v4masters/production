<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>School Register</title>

    <meta name="description" content="" />
    @include('includes.header_script')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }} " />
    <!-- Helpers -->

    <style>
        /* Style the form */
        #regForm {
            background-color: #ffffff;

        }

        /* Style the input fields */
        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #696CFF !important;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        /* Mark the active step: */
        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #696CFF !important;
        }

        .select_search {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            border: 1px solid #aaaaaa;
        }
    </style>

</head>
<script>
    var stateObject = {
        "India": {
            "Himachal Pradesh": [
                "Bilaspur",
                "Chamba",
                "Hamirpur",
                "Kangra",
                "Kinnaur",
                "Kullu",
                "Lahaul and Spiti",
                "Mandi",
                "Shimla",
                "Sirmaur (Sirmour)",
                "Solan",
                "Una"
            ],

            "Andhra Pradesh": [

                "Anantapur",
                "Chittoor",
                "East Godavari",
                "Guntur",
                "Krishna",
                "Kurnool",
                "Nellore",
                "Prakasam",
                "Srikakulam",
                "Visakhapatnam",
                "Vizianagaram",
                "West Godavari",
                "YSR Kadapa"
            ],

            "Arunachal Pradesh": [
                "Tawang",
                "West Kameng",
                "East Kameng",
                "Papum Pare",
                "Kurung Kumey",
                "Kra Daadi",
                "Lower Subansiri",
                "Upper Subansiri",
                "West Siang",
                "East Siang",
                "Siang",
                "Upper Siang",
                "Lower Siang",
                "Lower Dibang Valley",
                "Dibang Valley",
                "Anjaw",
                "Lohit",
                "Namsai",
                "Changlang",
                "Tirap",
                "Longding"
            ],
            "Assam": [
                "Baksa",
                "Barpeta",
                "Biswanath",
                "Bongaigaon",
                "Cachar",
                "Charaideo",
                "Chirang",
                "Darrang",
                "Dhemaji",
                "Dhubri",
                "Dibrugarh",
                "Goalpara",
                "Golaghat",
                "Hailakandi",
                "Hojai",
                "Jorhat",
                "Kamrup Metropolitan",
                "Kamrup",
                "Karbi Anglong",
                "Karimganj",
                "Kokrajhar",
                "Lakhimpur",
                "Majuli",
                "Morigaon",
                "Nagaon",
                "Nalbari",
                "Dima Hasao",
                "Sivasagar",
                "Sonitpur",
                "South Salmara-Mankachar",
                "Tinsukia",
                "Udalguri",
                "West Karbi Anglong"
            ],

            "Bihar": [
                "Araria",
                "Arwal",
                "Aurangabad",
                "Banka",
                "Begusarai",
                "Bhagalpur",
                "Bhojpur",
                "Buxar",
                "Darbhanga",
                "East Champaran (Motihari)",
                "Gaya",
                "Gopalganj",
                "Jamui",
                "Jehanabad",
                "Kaimur (Bhabua)",
                "Katihar",
                "Khagaria",
                "Kishanganj",
                "Lakhisarai",
                "Madhepura",
                "Madhubani",
                "Munger (Monghyr)",
                "Muzaffarpur",
                "Nalanda",
                "Nawada",
                "Patna",
                "Purnia (Purnea)",
                "Rohtas",
                "Saharsa",
                "Samastipur",
                "Saran",
                "Sheikhpura",
                "Sheohar",
                "Sitamarhi",
                "Siwan",
                "Supaul",
                "Vaishali",
                "West Champaran"
            ],

            "Chandigarh (UT)": [
                "Chandigarh"
            ],


            "Chhattisgarh": [
                "Balod",
                "Baloda Bazar",
                "Balrampur",
                "Bastar",
                "Bemetara",
                "Bijapur",
                "Bilaspur",
                "Dantewada (South Bastar)",
                "Dhamtari",
                "Durg",
                "Gariyaband",
                "Janjgir-Champa",
                "Jashpur",
                "Kabirdham (Kawardha)",
                "Kanker (North Bastar)",
                "Kondagaon",
                "Korba",
                "Korea (Koriya)",
                "Mahasamund",
                "Mungeli",
                "Narayanpur",
                "Raigarh",
                "Raipur",
                "Rajnandgaon",
                "Sukma",
                "Surajpur  ",
                "Surguja"
            ],

            "Dadra and Nagar Haveli (UT)": [
                "Dadra and Nagar Haveli"
            ],

            "Daman and Diu (UT)": [
                "Daman",
                "Diu"
            ],

            "Delhi (NCT)": [
                "Central Delhi",
                "East Delhi",
                "New Delhi",
                "North Delhi",
                "North East  Delhi",
                "North West  Delhi",
                "Shahdara",
                "South Delhi",
                "South East Delhi",
                "South West  Delhi",
                "West Delhi"
            ],

            "Goa": [
                "North Goa",
                "South Goa"
            ],

            "Gujarat": [
                "Ahmedabad",
                "Amreli",
                "Anand",
                "Aravalli",
                "Banaskantha (Palanpur)",
                "Bharuch",
                "Bhavnagar",
                "Botad",
                "Chhota Udepur",
                "Dahod",
                "Dangs (Ahwa)",
                "Devbhoomi Dwarka",
                "Gandhinagar",
                "Gir Somnath",
                "Jamnagar",
                "Junagadh",
                "Kachchh",
                "Kheda (Nadiad)",
                "Mahisagar",
                "Mehsana",
                "Morbi",
                "Narmada (Rajpipla)",
                "Navsari",
                "Panchmahal (Godhra)",
                "Patan",
                "Porbandar",
                "Rajkot",
                "Sabarkantha (Himmatnagar)",
                "Surat",
                "Surendranagar",
                "Tapi (Vyara)",
                "Vadodara",
                "Valsad"
            ],

            "Haryana": [
                "Ambala",
                "Bhiwani",
                "Charkhi Dadri",
                "Faridabad",
                "Fatehabad",
                "Gurgaon",
                "Hisar",
                "Jhajjar",
                "Jind",
                "Kaithal",
                "Karnal",
                "Kurukshetra",
                "Mahendragarh",
                "Mewat",
                "Palwal",
                "Panchkula",
                "Panipat",
                "Rewari",
                "Rohtak",
                "Sirsa",
                "Sonipat",
                "Yamunanagar"
            ],


            "Jammu and Kashmir": [
                "Anantnag",
                "Bandipore",
                "Baramulla",
                "Budgam",
                "Doda",
                "Ganderbal",
                "Jammu",
                "Kargil",
                "Kathua",
                "Kishtwar",
                "Kulgam",
                "Kupwara",
                "Leh",
                "Poonch",
                "Pulwama",
                "Rajouri",
                "Ramban",
                "Reasi",
                "Samba",
                "Shopian",
                "Srinagar",
                "Udhampur"
            ],

            "Jharkhand": [
                "Bokaro",
                "Chatra",
                "Deoghar",
                "Dhanbad",
                "Dumka",
                "East Singhbhum",
                "Garhwa",
                "Giridih",
                "Godda",
                "Gumla",
                "Hazaribag",
                "Jamtara",
                "Khunti",
                "Koderma",
                "Latehar",
                "Lohardaga",
                "Pakur",
                "Palamu",
                "Ramgarh",
                "Ranchi",
                "Sahibganj",
                "Seraikela-Kharsawan",
                "Simdega",
                "West Singhbhum"
            ],

            "Karnataka": [
                "Bagalkot",
                "Ballari (Bellary)",
                "Belagavi (Belgaum)",
                "Bengaluru (Bangalore) Rural",
                "Bengaluru (Bangalore) Urban",
                "Bidar",
                "Chamarajanagar",
                "Chikballapur",
                "Chikkamagaluru (Chikmagalur)",
                "Chitradurga",
                "Dakshina Kannada",
                "Davangere",
                "Dharwad",
                "Gadag",
                "Hassan",
                "Haveri",
                "Kalaburagi (Gulbarga)",
                "Kodagu",
                "Kolar",
                "Koppal",
                "Mandya",
                "Mysuru (Mysore)",
                "Raichur",
                "Ramanagara",
                "Shivamogga (Shimoga)",
                "Tumakuru (Tumkur)",
                "Udupi",
                "Uttara Kannada (Karwar)",
                "Vijayapura (Bijapur)",
                "Yadgir"
            ],

            "Kerala": [
                "Alappuzha",
                "Ernakulam",
                "Idukki",
                "Kannur",
                "Kasaragod",
                "Kollam",
                "Kottayam",
                "Kozhikode",
                "Malappuram",
                "Palakkad",
                "Pathanamthitta",
                "Thiruvananthapuram",
                "Thrissur",
                "Wayanad"
            ],

            "Lakshadweep (UT)": [
                "Agatti",
                "Amini",
                "Androth",
                "Bithra",
                "Chethlath",
                "Kavaratti",
                "Kadmath",
                "Kalpeni",
                "Kilthan",
                "Minicoy"
            ],

            "Madhya Pradesh": [
                "Agar Malwa",
                "Alirajpur",
                "Anuppur",
                "Ashoknagar",
                "Balaghat",
                "Barwani",
                "Betul",
                "Bhind",
                "Bhopal",
                "Burhanpur",
                "Chhatarpur",
                "Chhindwara",
                "Damoh",
                "Datia",
                "Dewas",
                "Dhar",
                "Dindori",
                "Guna",
                "Gwalior",
                "Harda",
                "Hoshangabad",
                "Indore",
                "Jabalpur",
                "Jhabua",
                "Katni",
                "Khandwa",
                "Khargone",
                "Mandla",
                "Mandsaur",
                "Morena",
                "Narsinghpur",
                "Neemuch",
                "Panna",
                "Raisen",
                "Rajgarh",
                "Ratlam",
                "Rewa",
                "Sagar",
                "Satna",
                "Sehore",
                "Seoni",
                "Shahdol",
                "Shajapur",
                "Sheopur",
                "Shivpuri",
                "Sidhi",
                "Singrauli",
                "Tikamgarh",
                "Ujjain",
                "Umaria",
                "Vidisha"
            ],

            "Maharashtra": [
                "Ahmednagar",
                "Akola",
                "Amravati",
                "Aurangabad",
                "Beed",
                "Bhandara",
                "Buldhana",
                "Chandrapur",
                "Dhule",
                "Gadchiroli",
                "Gondia",
                "Hingoli",
                "Jalgaon",
                "Jalna",
                "Kolhapur",
                "Latur",
                "Mumbai City",
                "Mumbai Suburban",
                "Nagpur",
                "Nanded",
                "Nandurbar",
                "Nashik",
                "Osmanabad",
                "Palghar",
                "Parbhani",
                "Pune",
                "Raigad",
                "Ratnagiri",
                "Sangli",
                "Satara",
                "Sindhudurg",
                "Solapur",
                "Thane",
                "Wardha",
                "Washim",
                "Yavatmal"
            ],


            "Manipur": [
                "Bishnupur",
                "Chandel",
                "Churachandpur",
                "Imphal East",
                "Imphal West",
                "Jiribam",
                "Kakching",
                "Kamjong",
                "Kangpokpi",
                "Noney",
                "Pherzawl",
                "Senapati",
                "Tamenglong",
                "Tengnoupal",
                "Thoubal",
                "Ukhrul"
            ],

            "Meghalaya": [
                "East Garo Hills",
                "East Jaintia Hills",
                "East Khasi Hills",
                "North Garo Hills",
                "Ri Bhoi",
                "South Garo Hills",
                "South West Garo Hills ",
                "South West Khasi Hills",
                "West Garo Hills",
                "West Jaintia Hills",
                "West Khasi Hills"
            ],

            "Mizoram": [
                "Aizawl",
                "Champhai",
                "Kolasib",
                "Lawngtlai",
                "Lunglei",
                "Mamit",
                "Saiha",
                "Serchhip"
            ],

            "Nagaland": [
                "Dimapur",
                "Kiphire",
                "Kohima",
                "Longleng",
                "Mokokchung",
                "Mon",
                "Peren",
                "Phek",
                "Tuensang",
                "Wokha",
                "Zunheboto"
            ],

            "Odisha": [
                "Angul",
                "Balangir",
                "Balasore",
                "Bargarh",
                "Bhadrak",
                "Boudh",
                "Cuttack",
                "Deogarh",
                "Dhenkanal",
                "Gajapati",
                "Ganjam",
                "Jagatsinghapur",
                "Jajpur",
                "Jharsuguda",
                "Kalahandi",
                "Kandhamal",
                "Kendrapara",
                "Kendujhar (Keonjhar)",
                "Khordha",
                "Koraput",
                "Malkangiri",
                "Mayurbhanj",
                "Nabarangpur",
                "Nayagarh",
                "Nuapada",
                "Puri",
                "Rayagada",
                "Sambalpur",
                "Sonepur",
                "Sundargarh"
            ],

            "Puducherry (UT)": [
                "Karaikal",
                "Mahe",
                "Pondicherry",
                "Yanam"
            ],

            "Punjab": [
                "Amritsar",
                "Barnala",
                "Bathinda",
                "Faridkot",
                "Fatehgarh Sahib",
                "Fazilka",
                "Ferozepur",
                "Gurdaspur",
                "Hoshiarpur",
                "Jalandhar",
                "Kapurthala",
                "Ludhiana",
                "Mansa",
                "Moga",
                "Muktsar",
                "Nawanshahr (Shahid Bhagat Singh Nagar)",
                "Pathankot",
                "Patiala",
                "Rupnagar",
                "Sahibzada Ajit Singh Nagar (Mohali)",
                "Sangrur",
                "Tarn Taran"
            ],

            "Rajasthan": [
                "Ajmer",
                "Alwar",
                "Banswara",
                "Baran",
                "Barmer",
                "Bharatpur",
                "Bhilwara",
                "Bikaner",
                "Bundi",
                "Chittorgarh",
                "Churu",
                "Dausa",
                "Dholpur",
                "Dungarpur",
                "Hanumangarh",
                "Jaipur",
                "Jaisalmer",
                "Jalore",
                "Jhalawar",
                "Jhunjhunu",
                "Jodhpur",
                "Karauli",
                "Kota",
                "Nagaur",
                "Pali",
                "Pratapgarh",
                "Rajsamand",
                "Sawai Madhopur",
                "Sikar",
                "Sirohi",
                "Sri Ganganagar",
                "Tonk",
                "Udaipur"
            ],

            "Sikkim": [
                "East Sikkim",
                "North Sikkim",
                "South Sikkim",
                "West Sikkim"
            ],

            "Tamil Nadu": [
                "Ariyalur",
                "Chennai",
                "Coimbatore",
                "Cuddalore",
                "Dharmapuri",
                "Dindigul",
                "Erode",
                "Kanchipuram",
                "Kanyakumari",
                "Karur",
                "Krishnagiri",
                "Madurai",
                "Nagapattinam",
                "Namakkal",
                "Nilgiris",
                "Perambalur",
                "Pudukkottai",
                "Ramanathapuram",
                "Salem",
                "Sivaganga",
                "Thanjavur",
                "Theni",
                "Thoothukudi (Tuticorin)",
                "Tiruchirappalli",
                "Tirunelveli",
                "Tiruppur",
                "Tiruvallur",
                "Tiruvannamalai",
                "Tiruvarur",
                "Vellore",
                "Viluppuram",
                "Virudhunagar"
            ],

            "Telangana": [
                "Adilabad",
                "Bhadradri Kothagudem",
                "Hyderabad",
                "Jagtial",
                "Jangaon",
                "Jayashankar Bhoopalpally",
                "Jogulamba Gadwal",
                "Kamareddy",
                "Karimnagar",
                "Khammam",
                "Komaram Bheem Asifabad",
                "Mahabubabad",
                "Mahabubnagar",
                "Mancherial",
                "Medak",
                "Medchal",
                "Nagarkurnool",
                "Nalgonda",
                "Nirmal",
                "Nizamabad",
                "Peddapalli",
                "Rajanna Sircilla",
                "Rangareddy",
                "Sangareddy",
                "Siddipet",
                "Suryapet",
                "Vikarabad",
                "Wanaparthy",
                "Warangal (Rural)",
                "Warangal (Urban)",
                "Yadadri Bhuvanagiri"
            ],

            "Tripura": [
                "Dhalai",
                "Gomati",
                "Khowai",
                "North Tripura",
                "Sepahijala",
                "South Tripura",
                "Unakoti",
                "West Tripura"
            ],

            "Uttarakhand": [
                "Almora",
                "Bageshwar",
                "Chamoli",
                "Champawat",
                "Dehradun",
                "Haridwar",
                "Nainital",
                "Pauri Garhwal",
                "Pithoragarh",
                "Rudraprayag",
                "Tehri Garhwal",
                "Udham Singh Nagar",
                "Uttarkashi"
            ],

            "Uttar Pradesh": [
                "Agra",
                "Aligarh",
                "Allahabad",
                "Ambedkar Nagar",
                "Amethi (Chatrapati Sahuji Mahraj Nagar)",
                "Amroha (J.P. Nagar)",
                "Auraiya",
                "Azamgarh",
                "Baghpat",
                "Bahraich",
                "Ballia",
                "Balrampur",
                "Banda",
                "Barabanki",
                "Bareilly",
                "Basti",
                "Bhadohi",
                "Bijnor",
                "Budaun",
                "Bulandshahr",
                "Chandauli",
                "Chitrakoot",
                "Deoria",
                "Etah",
                "Etawah",
                "Faizabad",
                "Farrukhabad",
                "Fatehpur",
                "Firozabad",
                "Gautam Buddha Nagar",
                "Ghaziabad",
                "Ghazipur",
                "Gonda",
                "Gorakhpur",
                "Hamirpur",
                "Hapur (Panchsheel Nagar)",
                "Hardoi",
                "Hathras",
                "Jalaun",
                "Jaunpur",
                "Jhansi",
                "Kannauj",
                "Kanpur Dehat",
                "Kanpur Nagar",
                "Kanshiram Nagar (Kasganj)",
                "Kaushambi",
                "Kushinagar (Padrauna)",
                "Lakhimpur - Kheri",
                "Lalitpur",
                "Lucknow",
                "Maharajganj",
                "Mahoba",
                "Mainpuri",
                "Mathura",
                "Mau",
                "Meerut",
                "Mirzapur",
                "Moradabad",
                "Muzaffarnagar",
                "Pilibhit",
                "Pratapgarh",
                "RaeBareli",
                "Rampur",
                "Saharanpur",
                "Sambhal (Bhim Nagar)",
                "Sant Kabir Nagar",
                "Shahjahanpur",
                "Shamali (Prabuddh Nagar)",
                "Shravasti",
                "Siddharth Nagar",
                "Sitapur",
                "Sonbhadra",
                "Sultanpur",
                "Unnao",
                "Varanasi"
            ],

            "West Bengal": [
                "Alipurduar",
                "Bankura",
                "Birbhum",
                "Burdwan (Bardhaman)",
                "Cooch Behar",
                "Dakshin Dinajpur (South Dinajpur)",
                "Darjeeling",
                "Hooghly",
                "Howrah",
                "Jalpaiguri",
                "Kalimpong",
                "Kolkata",
                "Malda",
                "Murshidabad",
                "Nadia",
                "North 24 Parganas",
                "Paschim Medinipur (West Medinipur)",
                "Purba Medinipur (East Medinipur)",
                "Purulia",
                "South 24 Parganas",
                "Uttar Dinajpur (North Dinajpur)"
            ]


        },

    }
    window.onload = function() {

        var countySel = document.getElementById("countySel"),
            stateSel = document.getElementById("stateSel"),
            districtSel = document.getElementById("districtSel");

        for (var country in stateObject) {
            document.getElementById("countySel").value = "India";
        }
        countySel.onchange = function() {
            stateSel.length = 1; // remove all options bar first
            // districtSel.length = 0; // remove all options bar first
            if (this.selectedIndex < 1) return; // done
            for (var state in stateObject[this.value]) {
                stateSel.options[stateSel.options.length] = new Option(state, state);
            }
        }
        countySel.onchange(); // reset in case page is reloaded
        stateSel.onchange = function() {
            districtSel.length = 0; // remove all options bar first
            if (this.selectedIndex < 1) return; // done
            var district = stateObject[countySel.value][this.value];
            for (var i = 0; i < district.length; i++) {
                districtSel.options[districtSel.options.length] = new Option(district[i], district[i]);
            }

        }

    }
</script>

<body>
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">

                                </span>
                                <img src="{{ asset('assets/img/logo/evyapari-logo-1.png') }}" alt="Logo" width="150">
                            </a>
                        </div>
                        <!-- /Logo -->


                        <form action="{{url('/') }}/register" method="POST" class="user" id="regForm">
                            @csrf
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif


                            @if(session('success'))
                            <div class="alert alert-primary">
                                {{ session('success') }}
                            </div>
                            @endif

                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">School Name</label>-->
                            <!--    <input type="text" class="form-control" name="school_name" placeholder="School Name">-->
                            <!--</div>-->

                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Email</label>-->
                            <!--    <input type="email" class="form-control" name="school_email" placeholder="School Email " />-->
                            <!--</div>-->

                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Mobile No.</label>-->
                            <!--    <input type="text" class="form-control" name="school_phone" placeholder="parents/Guardian (use for OTP verification)" />-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">School Code</label>-->
                            <!--    <input type="number" class="form-control" name="school_code" placeholder="Student School Code" />-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Grade</label>-->

                            <!--    <select class="form-select"  name="grade">-->
                            <!--         <option hidden disabled selected>--Select Grade--</option>-->


                            <!--    </select>-->
                            <!--</div>-->
                            <!--   <div class="mb-3">-->
                            <!--    <label class="form-label">Board</label>-->

                            <!--    <select class="form-select" name="board">-->
                            <!--         <option hidden disabled selected>--Select Board--</option>-->


                            <!--    </select>-->
                            <!--</div>-->
                            <!--   <div class="mb-3">-->
                            <!--    <label class="form-label">Select Organisation</label>-->
                            <!--    <select name="organisation" class="form-select">-->
                            <!--         <option hidden disabled selected>--Select Organisation--</option>-->

                            <!--    </select>-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Select State</label>-->
                            <!--    <select name="state" id="stateSel" class="form-select">-->
                            <!--        <option value="Himachal Pradesh" selected>Himachal Pradesh</option>-->
                            <!--    </select>-->
                            <!--</div>-->

                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Select Distt</label>-->
                            <!--    <select name="distt" id="districtSel" class="form-select" required>-->
                            <!--        <option hidden disabled selected>--Select Distt--</option>-->

                            <!--        <option value="Bilaspur">Bilaspur</option>-->
                            <!--        <option value="Chamba">Chamba</option>-->
                            <!--        <option value="Hamirpur">Hamirpur</option>-->
                            <!--        <option value="Kangra">Kangra</option>-->
                            <!--        <option value="Kinnaur">Kinnaur</option>-->
                            <!--        <option value="Kullu">Kullu</option>-->
                            <!--        <option value="Lahaul and Spiti">Lahaul and Spiti</option>-->
                            <!--        <option value="Mandi">Mandi</option>-->
                            <!--        <option value="Shimla">Shimla</option>-->
                            <!--        <option value="Sirmaur (Sirmour)">Sirmaur (Sirmour)</option>-->
                            <!--        <option value="Solan">Solan</option>-->
                            <!--        <option value="Una">Una</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Tehsil</label>-->
                            <!--    <input type="text" class="form-control" name="tehsil" placeholder="Tehsil" />-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Vill/Ward No.</label>-->
                            <!--    <input type="text" class="form-control" name="village" placeholder="Vill/Ward No." />-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Post Office</label>-->
                            <!--    <input type="text" class="form-control" name="post_office" placeholder="P.O." />-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Land Mark</label>-->
                            <!--    <input type="text" class="form-control" name="landmark" placeholder="Land Mark" />-->
                            <!--</div>-->
                            <!--<div class="mb-3">-->
                            <!--    <label class="form-label">Pincode</label>-->
                            <!--    <input type="number" class="form-control" name="zipcode" placeholder="Zipcode" />-->
                            <!--</div>-->

                            <!--<div class="mb-3 form-password-toggle">-->
                            <!--    <div class="d-flex justify-content-between">-->
                            <!--        <label class="form-label">Password</label>-->
                            <!--    </div>-->
                            <!--    <div class="input-group input-group-merge">-->
                            <!--        <input type="password" id="password" class="form-control" name="password" placeholder="six or more characters/Digit" />-->
                            <!--        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="mb-3">-->
                            <!--    <label for="password_confirmation" class="form-label">Confirm Password</label>-->
                            <!--    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>-->

                            <!--</div>-->


                            <div class="tab">
                                <h5>Step-1:</h5>
                                <p>

                                <div class="form-group mb-3">

                                    <label class="form-label">Organisation</label>
                                    <select class="form-select" name="organisation" required>

                                        <option hidden disabled selected>--Select Organisation--</option>
                                        @foreach($organisation as $key => $organisation)

                                        <option value="{{$organisation->id}}">{{$organisation->name}}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">School Grade</label>
                                    <select class="form-select select_search" name="grade" required>
                                        <option hidden disabled selected>--Select Grade--</option>
                                        @foreach($grade as $key => $grade)
                                        <option value="{{$grade->id}}">{{$grade->title}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Affilated Board</label>
                                    <select class="form-select" name="board" required>
                                        <option hidden disabled selected>--Select Board--</option>
                                        @foreach($board as $key => $board)
                                        <option value="{{$board->id}}">{{$board->title}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">School Code</label>
                                    <input type="text" class="form-control" name="school_code" placeholder="Student School Code" />
                                </div>
                                </p>

                            </div>

                            <div class="tab">
                                <h5>Step-2: (School Information)</h5>
                                <p>

                                <div class="mb-3">
                                    <label class="form-label">School Name</label>
                                    <input type="text" class="form-control" name="school_name" placeholder="School Name">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="school_email" placeholder="School Email (use for OTP verification) " />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">School Mobile No.</label>
                                    <input type="text" class="form-control" name="school_phone" placeholder="School Mobile Number" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Landline Number.</label>
                                    <input type="number" class="form-control" name="landline_no" placeholder=" Landline Number" />
                                </div>

                                </p>
                            </div>

                            <div class="tab">
                                <h5>Step-3: (School Postal Address)</h5>
                                <p>
                                <div class="mb-3">
                                    <label class="form-label">Vill/Ward No./Apartment/Mohalla</label>
                                    <textarea class="form-control" name="village" placeholder="Vill/Ward No./Apartment/Mohalla"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Post Office</label>
                                    <textarea class="form-control" name="post_office" placeholder="P.O."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Land Mark</label>
                                    <textarea class="form-control" name="landmark" placeholder="Land Mark"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="number" minlength="6"  maxlength="6" class="form-control" name="zipcode" placeholder="Pincode">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tehsil</label>
                                    <textarea class="form-control" name="tehsil" placeholder="Tehsil" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <input type="hidden" id="countySel" />
                                    <label class="form-label">Select State</label>
                                    <select name="state" id="stateSel" class="form-select" required>
                                        <option hidden disabled selected>--Select State--</option>

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Distt</label>
                                    <select name="distt" id="districtSel" class="form-select" required>
                                        <option hidden disabled selected>--Select Distt--</option>

                                        <option value="Bilaspur">Bilaspur</option>
                                        <option value="Chamba">Chamba</option>
                                        <option value="Hamirpur">Hamirpur</option>
                                        <option value="Kangra">Kangra</option>
                                        <option value="Kinnaur">Kinnaur</option>
                                        <option value="Kullu">Kullu</option>
                                        <option value="Lahaul and Spiti">Lahaul and Spiti</option>
                                        <option value="Mandi">Mandi</option>
                                        <option value="Shimla">Shimla</option>
                                        <option value="Sirmaur (Sirmour)">Sirmaur (Sirmour)</option>
                                        <option value="Solan">Solan</option>
                                        <option value="Una">Una</option>
                                    </select>
                                </div>

                                </p>
                            </div>
                            <div class="tab">
                                <h5>Step-4: (create Password)</h5>
                                <p>


                                <div class="mb-3 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="new_pass">Password</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="new_pass" onblur="CheckPassword(this.value)" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="con_pass">Confirm Password</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="con_pass" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    
                                    			<span class="pass_match_error" id="message" style="color:red;display:none;"></span>
					                  
                                </div>

                                <!--<div class="mb-3">-->
                                <!--    <label for="password_confirmation" class="form-label">Confirm Password</label>-->
                                <!--    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>-->

                                <!--</div>-->
                                </p>
                            </div>
                            <div style="overflow:auto;">
                                <div style="float:right;">
                                    <button type="button" class="btn btn-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                </div>
                            </div>

                            <!-- Circles which indicates the steps of the form: -->
                            <div style="text-align:center;margin-top:40px;">
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>


                            </div>

                        </form>
                        <div><a href="{{url('login')}}">Login Here!</a></div>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    @include('includes.footer_script')

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:regForm
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :
            if (currentTab >= x.length) {
                //...the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
        
        
        
        
        
$('#con_pass').on('keyup', function () {
  if ($('#new_pass').val() != $('#con_pass').val()) {
    $('#message').html('Passwords do not match.').css("display","block");
  } else 
  {
    $('#message').html('').css("display","none");
  }
});



// function CheckPassword(newpas) 
// { 
// var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
// if(newpas.match(passw)) 
// { 
// return true;
// }
// else
// { 
// return false;
// }
// }




// //Submit regForm
//  $('#regForm').submit(function(e) {
//  e.preventDefault();
 
//  alert('j');
   
//   var newpas=document.getElementById('new_pass').value;  
//   var conpass=document.getElementById('con_pass').value;  

     
     
//   if(CheckPassword(newpas)==false || CheckPassword(conpass)==false)
//   {
//   $('#message').html('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.').css("display","block");    
//     }
//     else
//     {
//       document.getElementById('regForm').submit();
    
//     }
// })

    </script>
</body>

</html>