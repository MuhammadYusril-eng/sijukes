            <!-- ========= All Javascript files linkup ======== -->
            <!-- <script src="../assets/js/bootstrap.bundle.min.js"></script> -->
            <script
                src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
                integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
                crossorigin="anonymous"></script>
            <script
                src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
                integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy"
                crossorigin="anonymous"></script>
            

            <script src="../assets/js/Chart.min.js"></script>
            <script src="../assets/js/apexcharts.min.js"></script>
            <script src="../assets/js/dynamic-pie-chart.js"></script>
            <script src="https://momentjs.com/downloads/moment.js"></script>
            <script src="../assets/js/jvectormap.min.js"></script>
            <script src="../assets/js/world-merc.js"></script>
            <script src="../assets/js/polyfill.js"></script>
            <script src="../assets/js/fullcalendar.js"></script>
            <script src="../assets/js/quill.min.js"></script>
            <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
            <script src="../assets/js/datatable.js"></script>
            <script src="../assets/js/Sortable.min.js"></script>
            <script src="../assets/js/main.js"></script>
            <script src="../../assets/js/wow.min.js"></script>
            

            <script>
                    
                    document.getElementById('searchInput').addEventListener('input', function() {
                      var searchValue = this.value.toLowerCase();
                      var table = document.getElementById('dataTable');
                      var rows = table.getElementsByTagName('tr');
                    
                      for (var i = 1; i < rows.length; i++) {
                          var row = rows[i];
                          var cells = row.getElementsByTagName('td');
                          var match = false;
                    
                          for (var j = 0; j < cells.length; j++) {
                              var cell = cells[j];
                              if (cell) {
                                  var cellValue = cell.textContent || cell.innerText;
                                  if (cellValue.toLowerCase().indexOf(searchValue) > -1) {
                                      match = true;
                                      break;
                                  }
                              }
                          }
                    
                          if (match) {
                              row.style.display = '';
                          } else {
                              row.style.display = 'none';
                          }
                      }
                    });
                                    </script>


<script>

      const dataTable = new simpleDatatables.DataTable("#table", {
        searchable: false,
      });

      const dataTable2 = new simpleDatatables.DataTable("#table2", {
        searchable: false,
      });

        const dataTable3 = new simpleDatatables.DataTable("#table3", {
        searchable: false,
        });
</script>

<script>


        const doughnutChart1 = new ApexCharts(
        document.querySelector("#chart"),
        (options = {
          series: [83, 67, 55, 44, 5, 43, 22, 12, 43],
          chart: {
            height: 435,
            type: "radialBar",
            fontFamily: "Inter",
          },

          plotOptions: {
            radialBar: {
              dataLabels: {
                name: {
                  fontSize: "22px",
                },
                value: {
                  fontSize: "16px",
                },
                total: {
                  show: true,
                  label: "Total",
                  formatter: function (w) {
                    return 100;
                  },
                },
              },
              hollow: {
                size: "20%",
              },
              track: {
                strokeWidth: "100%",
                margin: 7,
              },
            },
          },
          stroke: {
            lineCap: "round",
          },
        colors: ['#3e3ed3', '#5151d7', '#6363d8', '#7979dc', '#9191e2', '#a6a6e9', '#b8b8eb', '#c7c7ea', '#d6d6f0'],
        labels: ['Game Development', 'Mobile Application Development', 'Information Technology Development', 'Design Thinking', 'Software engineering', 'Website Based Application Development', 'Information System Development', 'Graphics and Multimedia', 'Application Development Fundamentals'],
        })
      );
      doughnutChart1.render();
</script>

<script>
        // Ketika gambar diklik
        $('a[data-bs-toggle="modal"]').on('click', function () {
            // Ambil URL gambar dari atribut data
            var imageUrl = $(this).data('image-url');

            // Set URL gambar ke elemen gambar di modal
            $('#previewImage').attr('src', imageUrl);

            // Munculkan modal
            $('#imageModal').modal('show');
        });
    </script>
    <script>
      // Menangkap semua gambar dengan class "image-thumbnail" (sesuaikan dengan class yang Anda gunakan)
var imageThumbnails = document.querySelectorAll(".img-thumbnail");

// Menangkap modal dan elemen gambar di dalamnya
var modal = document.getElementById("imagePreview");
var previewImage = document.getElementById("previewImage");

// Tambahkan event click ke setiap gambar kecil
imageThumbnails.forEach(function (thumbnail) {
    thumbnail.addEventListener("click", function () {
        // Setel sumber gambar modal ke sumber gambar gambar kecil yang diklik
        var imageSource = thumbnail.getAttribute("src");
        previewImage.setAttribute("src", imageSource);

        // Tampilkan modal
        modal.style.display = "block";
    });
});

// Menangkap tombol untuk menutup modal
var closeButton = document.querySelector(".close");

// Tambahkan event click untuk menutup modal
closeButton.addEventListener("click", function () {
    modal.style.display = "none";
});

    </script>
    
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                editable: true,
                events: 'fetch_events.php',
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    var title = prompt('Event Title:');
                    if (title) {
                        var start = moment(start).format('YYYY-MM-DD HH:mm:ss');
                        var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
                        $.ajax({
                            url: 'add_event.php',
                            data: 'title='+ title+'&start='+ start +'&end='+ end,
                            type: "POST",
                            success: function(json) {
                                alert('Added Successfully');
                            }
                        });
                        $('#calendar').fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: false
                        },
                        true
                        );
                    }
                    $('#calendar').fullCalendar('unselect');
                },
                editable: true,
                eventDrop: function(event, delta) {
                    var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    var end = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                    $.ajax({
                        url: 'update_event.php',
                        data: 'title='+ event.title+'&start='+ start +'&end='+ end+'&id='+ event.id ,
                        type: "POST",
                        success: function(json) {
                            alert("Updated Successfully");
                        }
                    });
                },
                eventClick: function(event) {
                    var deleteMsg = confirm("Do you really want to delete?");
                    if(deleteMsg) {
                        $.ajax({
                            type: "POST",
                            url: "delete_event.php",
                            data: "&id=" + event.id,
                            success: function(json) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                alert("Deleted Successfully");
                            }
                        });
                    }
                }
            });
        });


        
    </script>

            <svg
                id="SvgjsSvg1001"
                width="2"
                height="0"
                xmlns="http://www.w3.org/2000/svg"
                version="1.1"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns:svgjs="http://svgjs.com/svgjs"
                style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
                <defs id="SvgjsDefs1002"></defs>
                <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
                <path id="SvgjsPath1004" d="M0 0 "></path>
            </svg>
            <div class="jvm-tooltip"></div>
        </body>
    </html>
