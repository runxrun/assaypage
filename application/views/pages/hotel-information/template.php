<html>

<head>
  <title>HOTEL INFORMATION</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
  </style>
</head>

<body style="margin: 0; padding: 0;">
  <?php
  $pageMargin = 'margin: auto; ';
  $pageSize = 'width: 600px; ';
  $fontFamily = 'font-family: Inter, Arial, sans-serif; ';
  $lhBase = 'line-height: 125%; ';
  $fs4 = 'font-size: 1.5rem; ';
  $fs5 = 'font-size: 1.25rem; ';
  $fs6 = 'font-size: 1.0rem; ';
  $fs7 = 'font-size: 0.9rem; ';
  $fwBold = 'font-weight: bold; ';
  $cDark = 'color: #202020; ';
  $cSecondary = 'color: #6c757d; ';
  $cWhite = 'color: #ffffff;';
  $cStar = 'color: #ff9900; ';
  $py4 = 'padding-top: 1.5rem; padding-bottom: 1.5rem; ';
  $py3 = 'padding-top: 1rem; padding-bottom: 1rem; ';
  $px4 = 'padding-left: 1.5rem; padding-right: 1.5rem; ';
  $px3 = 'padding-left: 1rem; padding-right: 1rem; ';
  $pt1 = 'padding-top: 0.25rem; ';
  $ps3 = 'padding-left: 1rem; ';
  $pb4 = 'padding-bottom: 1.5rem; ';
  $pb3 = 'padding-bottom: 1rem; ';
  $pb2 = 'padding-bottom: 0.5rem; ';
  $pb1 = 'padding-bottom: 0.25rem; ';
  $pe4 = 'padding-right: 1.5rem; ';
  $pe3 = 'padding-right: 1rem; ';
  $pe2 = 'padding-right: 0.5rem; ';
  $pe1 = 'padding-right: 0.25rem; ';
  $w100 = 'width: 100%; ';
  $w50 = 'width: 50%; ';
  $textCenter = 'text-align: center; ';
  $borderTop = 'border-top: 1px solid #d7d7d7; ';
  $borderBottom = 'border-bottom: 1px solid #d7d7d7; ';


  $btnBook = 'background-color: #4285f4; border-radius: 0.25rem; text-decoration: none;';
  // background-color: #C00; 
  // border-radius: 0.25rem; 
  // color: #ffffff; 
  // text-decoration: none; 
  // padding: 1rem 
  // 2rem; 
  // font-size: 0.9rem


  ?>
  <div style="width:100%; background-color:#ffffff;">
    <div style="<?php echo $py4 . $pageMargin . $pageSize . $fontFamily . $lhBase; ?>">
      <div style="<?php echo $pb4 ?>">
        <table cellpadding="1" cellspacing="0">
          <tr valign="top">
            <td>
              <div style="<?php echo $fs4 . $fwBold . $cDark; ?>">
                Amaris Hotel Pasar Baru
              </div>
            </td>
            <td>
              <div style="<?php echo $pt1 . $ps3 . $fs6 . $cStar; ?>">
                &#9733;&#9733;&#9733; &#189;
                <!-- &#9734; -->
              </div>
            </td>
          </tr>
        </table>
      </div>
      <?php
      $images = [
        ['img' => 'https://media-cdn.tripadvisor.com/media/photo-s/0a/70/20/e3/hotel-exterior.jpg'],
        ['img' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0a/70/20/ea/smart-room-twin.jpg?w=800&h=500&s=1'],
        ['img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-OS2w1sFqEmO_QrKHFeuPRBTsWTOTaelfMg&s'],
        ['img' => 'https://pix10.agoda.net/property/781646/0/511baefa00810dfff80cfd57f47665f1.jpeg?ce=0&s=414x232'],
      ];
      ?>
      <table border="0" width="100%" cellpadding="1" cellspacing="0">
        <tr>
          <td>
            <div style="
              background-image: url('<?php echo $images[0]['img']; ?>');
              background-repeat: no-repeat;
              background-position: center;
              background-size: cover;
              width: 100%;
              height: 220px;
            ">
              &nbsp;
            </div>
          </td>
          <td>
            <div style="
              background-image: url('<?php echo $images[1]['img']; ?>');
              background-repeat: no-repeat;
              background-position: center;
              background-size: cover;
              width: 100%;
              height: 220px;
            ">
              &nbsp;
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div style="
              background-image: url('<?php echo $images[2]['img']; ?>');
              background-repeat: no-repeat;
              background-position: center;
              background-size: cover;
              width: 100%;
              height: 220px;
            ">
              &nbsp;
            </div>
          </td>
          <td>
            <div style="
              background-image: url('<?php echo $images[3]['img']; ?>');
              background-repeat: no-repeat;
              background-position: center;
              background-size: cover;
              width: 100%;
              height: 220px;
            ">
              &nbsp;
            </div>
          </td>
        </tr>
      </table>


      <div style="<?php echo $py4; ?>">
        <table border="0" width="100%" cellpadding="5" cellspacing="0">
          <tr valign="top">
            <td>
              <div style="<?php echo $fs7 . $fwBold . $cDark; ?>">
                Address
              </div>
            </td>
            <td>
              <div style="<?php echo $fs7 . $cSecondary; ?>">
                Jl. Pasar Baru Timur No. 20-21, Jakarta Puat, Indonesia
              </div>
            </td>
          </tr>
          <tr valign="top">
            <td>
              <div style="<?php echo $fs7 . $fwBold . $cDark; ?>">
                Location
              </div>
            </td>
            <td>
              <div style="<?php echo $fs7 . $cSecondary; ?>">
                Central Jakarta
              </div>
            </td>
          </tr>
          <tr valign="top">
            <td>
              <div style="<?php echo $fs7 . $fwBold . $cDark; ?>">
                Telephone number
              </div>
            </td>
            <td>
              <div style="<?php echo $fs7 . $cSecondary; ?>">
                +62 21 3501818
              </div>
            </td>
          </tr>
          <tr valign="top">
            <td>
              <div style="<?php echo $fs7 . $fwBold . $cDark; ?>">
                Fax number
              </div>
            </td>
            <td>
              <div style="<?php echo $fs7 . $cSecondary; ?>">
                +62 21 3510011
              </div>
            </td>
          </tr>
          <tr valign="top">
            <td>
              <div style="<?php echo $fs7 . $fwBold . $cDark; ?>">
                Total rooms
              </div>
            </td>
            <td>
              <div style="<?php echo $fs7 . $cSecondary; ?>">
                102
              </div>
            </td>
          </tr>
          <tr valign="top">
            <td>
              <div style="<?php echo $fs7 . $fwBold . $cDark; ?>">
                Style
              </div>
            </td>
            <td>
              <div style="<?php echo $fs7 . $cSecondary; ?>">
                Hotel
              </div>
            </td>
          </tr>
        </table>
      </div>

      <div style="<?php echo $pb4; ?>">
        <div style="<?php echo $py3 . $borderTop . $borderBottom . $textCenter; ?>">
          <div style="<?php echo $py4; ?>">
            <a href="http://www.assaypage.com/" style="<?php echo $btnBook . $px4 . $py3 . $fs7 . $cWhite . $fwBold; ?>">BOOK NOW</a>
          </div>
        </div>
      </div>

      <div style="<?php echo $pb2 . $fs6 . $fwBold . $cDark; ?>">
        Hotel Description
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        Offering a restaurant, Amaris Hotel Pasar Baru is located a short drive from Pasar Baru. Free WiFi access and complimentary parking privileges are available. Each room here will provide you with a flat-screen cable TV, air conditioning and a safety deposit box. Featuring a shower, private bathroom also comes with free toiletries and slippers. You can enjoy city view from the room. At Amaris Hotel Pasar Baru you will find a 24-hour front desk that provides luggage storage and laundry service. Other facilities offered at the property include meeting rooms and daily housekeeping. The property offers free parking. A selection of Indonesian and Western food can be sampled at Express Restaurant. Alternatively, guests may find plenty of eateries at Pecenongan Street, located a 10-minute drive away. The nearest mini-market is a 5-minute walk away.
      </div>


      <div style="<?php echo $pb2 . $fs6 . $fwBold . $cDark; ?>">
        Room Information
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        The Smart Room Queen is fully air-conditioned with attached shower. Services such as wake up call and daily mineral water are also provided to the guests. To ensure the safety of guests’ belongings, a safety deposit box is also provided. Breakfast is included.

        Smart Room Twin is an air-conditioned room with twin bedding and attached shower. Services such as wake up call and daily mineral water are also provided to the guests. To ensure the safety of our guests’ belongings, a safety deposit box is also provided. Complimentary breakfast is included.
      </div>


      <div style="<?php echo $pb2 . $fs6 . $fwBold . $cDark; ?>">
        Location Information
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        Amaris Hotel Pasarbaru is conveniently located next to the Pasar Baru shopping center, only with 5 minutes of walk. The hotel can also grant quick 15 minutes access to the Jakarta International Expo.
      </div>


      <div style="<?php echo $pb2 . $fs6 . $fwBold . $cDark; ?>">
        Facilities Information
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        @EXPRESS
        Taste our simple yet flavourful food in a casual outdoor setting at @Xpress resturant in Amaris Hotel Pasar Baru. Enjoy a meal, coffee, or quick snack at your convenience, without having to leave the hotel. Choose from a variety of tasty dishes, while enjoying the fresh air and sunshine. @Xpress provides a simple and straight forward breakfast, as well as light snacks and a variety of beverages.
      </div>
      <div style="<?php echo $pb2 . $fs7 . $fwBold . $cDark; ?>">
        Business Facilities
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        Banquet
        . Business Center
        . Fax
        . Internet Service
        . Meeting Rooms
      </div>
      <div style="<?php echo $pb2 . $fs7 . $fwBold . $cDark; ?>">
        Dining/Entertainment
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        Buffet
        . Coffee
        . Dining Room
        . Entertainment
      </div>
      <div style="<?php echo $pb2 . $fs7 . $fwBold . $cDark; ?>">
        Hotel Facilities
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        Elevator
        . Garden
        . Luggage Storage
        . Multilingual
        . Newspaper
        . Parking
        . Safe Deposit Box
        . Smoke Alarm
        . Valetpark
      </div>
      <div style="<?php echo $pb2 . $fs7 . $fwBold . $cDark; ?>">
        Recreational Facilities
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        Fitness Center
        . Swimming Pool
      </div>
      <div style="<?php echo $pb2 . $fs7 . $fwBold . $cDark; ?>">
        Room Facilities
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        220 Volt
        . 24 Room Service
        . Air-condition
        . Alarm Clock
        . Babycot
        . Hairdryer
        . IDD Phone
        . Non Smoking Room
        . Telephone
        . TV
        . Water
        . Wifi
        . Workdesk
      </div>
      <div style="<?php echo $pb2 . $fs7 . $fwBold . $cDark; ?>">
        Services
      </div>
      <div style="<?php echo $pb3 . $fs7  . $cSecondary; ?>">
        Airport Transfer
        . Concierge
        . Credit Card
        . Laundry
        . Room Service
        . Taxi
        . Tour Desk
      </div>
    </div>
  </div>
</body>

</html>