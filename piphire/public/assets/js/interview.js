var interviewData = null;



function uploadProcess1() {

    var fileUpload = document.getElementById("excel-file")
    // validate proper file type
    var file = fileUpload.files[0]

    var regex = /^([a-zA-Z0-9\s_\(\)\\.\-:])+(.xls|.xlsx)$/

    if (regex.test(file.name)) {
        var reader = new FileReader();
        if (reader.readAsBinaryString) {
            reader.onload = function (e) {
                var data = getResult1(e.target.result)
                try {

                    //match header
                    var header = [];
                    for (var headers in data[0]) {
                        header.push(headers)
                    }

                    var a = header;
                    var b = [
                        "#",
                        // "Request ID",
                        "Interviewer Name",
                        "Duration",
                        "Start Date",
                        "End Date",
                        "Start Time",
                        "End Time",

                        "Email Address",
                        "Contact Number",
                        "Meeting Body"

                    ];

                    if (data.length == 0) {
                        alert("No entries were found in excel file")
                    } else if (Object.keys(data[0]).length == 10 && (JSON.stringify(a) == JSON.stringify(b))) {
                        // console.log(data[0,1],'jiiii')
                        var columnTitles = [
                            "Interviewer Name",
                            "Duration",
                            "Start Date",
                            "End Date",
                            "Start Time",
                            "End Time",

                            "Email Address",
                            "Contact Number",
                            "Meeting Body"
                        ];
                        var count = 1
                        Object.keys(data[0]).map(item => {
                            if (columnTitles.includes(item)) {
                                count += 1
                            }
                        })
                        if (count < 3) {
                            alert("Wrong file")
                            return
                        }

                        var totalJobs = 0
                        //  var id= data.header;
                        //  console.log( __rowNum__[0],'headerrrrrrrrrrrrrrrrrrrrr')
                        interviewData = data.map(d => {
                            // if (d["Job Title"]) {

                            //     totalJobs += parseInt(d["Vacant Positions"] ? d["Vacant Positions"] : 1)
                            //     console.log('hiiii')

                            // }


                            return {
                                
                                "int_name": d["Interviewer Name"],
                                "duration": d["Duration"],
                                "start_date": d["Start Date"],
                                "end_date": d["End Date"],
                                "start_time": d["Start Time"],
                                "end_time": d["End Time"],
                                "email": d["Email Address"],
                                "contact": d["Contact Number"],
                                "details": d["Meeting Body"],

                            }


                        }).filter(d => d["int_name"])


                        createTable1(data);
                        presentTableScreen1();


                    } else {
                        interviewData = null;
                        alert("Please download and use the Template File provided")
                    }




                } catch (err) {
                    alert("There was an error in reading the data")
                    interviewData = null;

                }

            }
            reader.readAsBinaryString(file)

        }

    } else {
        alert("Please download and use the Template File provided");
        console.log("failed");
    }

}


function getResult1(data) {
    var workbook = XLSX.read(data, {
        type: 'binary'
    })
    var sheet = workbook.SheetNames[0]
    var rows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
    return rows
}

function createTable1(data) {
    if (interviewData) {
        console.log(interviewData, 'llllllllllllllllllllll')
        document.getElementById('jobsSendButton1').disabled = false;
        var table = document.getElementById('dataTable1')
        // var row = table.insertRow(-1);
        var tableBody = document.createElement('tbody');
        tableBody.id = "tableBody"
        var oldTableBody = document.getElementById('tableBody');

        for (var i = 0; i < data.length; i++) {
            if (i == 0) {
                var row = tableBody.insertRow(-1);
                for (const header in data[0]) {
                    var headerCell = document.createElement("TH")

                    if (header == "Interviewer Name") {
                        // headerCell.style.width = "500px";
                        // console.log(headerCell.style.width)
                        var span = document.createElement("SPAN");
                        span.innerHTML = header;
                        var span2 = document.createElement("SPAN");
                        span2.innerHTML = "..........................................................................................";
                        span2.style.opacity = 0.001;
                        span.appendChild(span2);
                        headerCell.appendChild(span);
                    } else {
                        headerCell.innerHTML = header
                    }
                    row.appendChild(headerCell);
                }
                // console.log(header[0],'yesss')
            }

            var row = tableBody.insertRow(-1)
            for (key in data[i]) {
                if (data[i]["Interviewer Name"]) {
                    var cell = row.insertCell(-1)
                    if (key == "Interviewer Name") {
                        // cell.classList.add("tableDescription");

                    }
                    cell.innerHTML = data[i][key]

                }
            }
        }

        // table.appendChild(tableBody);
        table.replaceChild(tableBody, oldTableBody);

    } else {
        document.getElementById('jobsSendButton1').disabled = true;
    }
}


function presentTableScreen1() {

    document.getElementById('dataTable1').classList.remove('d-none');
    document.getElementById('jobsSendButton1').classList.remove('d-none');
    document.getElementById('backButton1').classList.remove('d-none');
    document.getElementById('fileReadButton1').classList.add('d-none')
    document.getElementById('upload-section1').classList.add('d-none')
    // document.getElementById('spin').classList.add('d-none');

}

function onFileSubmit1() {
    // $(this).toggleClass('active');
    // $('#spin').show();
    // $('#fileReadButton1').hide();


    uploadProcess1();

    // presentTableScreen1()



}


function onJobsSubmit1() {
    $('#spin').show();
    $('#jobsSendButton1').hide();
    postBulkJobs1().then(data => {
        // console.log(data)
    })
}

async function postBulkJobs1() {
    // fetch()
    // var title = document.getElementById("job-title").value

    console.log(interviewData, 'pppppppppppppppp')
    var csrf = $('meta[name="csrf-token"]').attr('content')

    document.getElementById('jobsSendButton1').disabled = true;
    try {
        var response = await fetch(window.location.origin + "/Update/Interview/job", {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({

                "payload": interviewData
            })

        })

        var res = await response.json()
        console.log(res)

        if (res.status) {
            $('#spin').show();
            location.reload();
            // location.href = "bulkJobs/" + res.data;
            // document.getElementById('jobsSendButton1').disabled = false;
        } else {
            // alert(res.message);
            $('#spin').show();
            location.reload();
            // document.getElementById('jobsSendButton1').disabled = true;
        }
    } catch (err) {
        console.log(err);
        document.getElementById('jobsSendButton1').disabled = true;
        alert("There was some issue with the server");
        location.reload();

    }



    return res

}