<?php 
    include 'connection.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }
    
    if (empty($user_id)) {
        $_SESSION['user_name'] = '';
        $_SESSION['user_email'] = '';
    } else {

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <link rel="stylesheet" href="asset/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</body>
    <?php 
        include 'header.php';
    ?>
    <div class="container">
        <h3 class='content-1'>EST.2008</h3>
        <h1 class='content-2'>WE ARE A FAMILY-RUN FLOWER FARM & SEED COMPANY, SPECIALIZING IN UNIQUE, UNCOMMON & HEIRLOOM FLOWERS</h1>
        <h2 class='content-3'>OUR THRIVING RESEARCH & EDUCATION FARM IS DEDICATED TO GIVING FLOWER LOVERS THE TOOLS & INFORMATION THEY NEED TO GROW THE GARDENS OF THEIR DREAMS</h2>
        <p class='content-4'>Set in Washington’s beautiful Skagit Valley, our fields are bursting with flowers that reflect the season, from fragrant sweet peas in the spring to magnificent dinner plate dahlias in the fall and countless varieties in between. Research is at the heart of our operation, and we conduct extensive trials to find the very best cut flower varieties, coveted for their scent, stem length, and ethereal qualities.</p>
        <p class='content-4'>We source seeds from a small network of specialty seed farmers and grow many of the varieties we offer right here on the farm. Our shop features my very favorite cut flower seeds, as well as tools, supplies, and signed Floret books.</p>
        <div class="flex-img">
            <div class="flex-img-1">
                <img class="img-fluid" src="image/about1.jpg" alt="">
                <img class="img-fluid" src="image/about2.jpg" alt="">
            </div>
            <div class="flex-img-2">
                <img class="img-fluid" src="image/about3.jpg" alt="">
            </div>
        </div>
        <p class='content-4'>Much of my childhood was spent at my great-grandparents’ country home, and from an early age, under their influence, I felt a deep sense of connection to nature. From then on I dreamed of living in the country, where we’d grow our own vegetables, raise chickens, and plant a small orchard. So in 2001, my family and I left the hustle of city life in Seattle and moved to a small farm in Washington’s Skagit Valley to pursue a slower, simpler, more intentional lifestyle that would help us connect with nature every day. Shortly after we arrived, a generous neighbor brought over his tractor to till a plot of ground so I could finally have the garden of my dreams.</p>
        <p class='content-4'>Tucked among the many vegetables in that first garden was a double row of sweet peas, planted in memory of my great-grandmother, who had recently passed away. Grammy called me her “little flower girl” when I was a young child, and I was tasked with making bouquets for her bedside table during my annual summer visits. Though my creations were simple, she always cooed over them as if they were the most precious things on Earth. So when the first sweet peas bloomed in my garden, I felt as if Grammy were there with me, cheering me on in my new endeavor.</p>
        <p class='content-4'>Our garden overflowed that first season, and I shared the bounty with family, friends, and new neighbors. Soon, word got out about our abundant plot, and people I didn’t yet know began asking if they could order our flowers. I had never intended to sell flowers, but I loved gifting them and sharing their beauty. When I delivered my first paid order—a simple jar of sweet peas—I nervously thrust the bouquet into the customer’s hands as soon as she opened her door. For a moment, time slowed as she buried her nose in the blooms. Tears filled her eyes, and she said that the fragrance transported her back in time to happy childhood summers in her grandmother’s garden. Seeing how a small bouquet of flowers had the power to stir such emotion and connect two perfect strangers, in a matter of seconds, was a turning point for me. I knew then and there that I had found my calling, and I wanted to devote my life to making other people’s lives more beautiful with flowers.</p>
        <div class="flex-img">
            <div class="flex-img-1">
                <img class="img-fluid" src="image/about4.jpg" alt="">
                <img class="img-fluid" src="image/about5.jpg" alt="">
            </div>
            <div class="flex-img-2">
                <img  src="image/about6.jpg" alt="">
            </div>
        </div>
        <p class='content-4'>The following year I replaced all of our vegetables with flowers, and the year after that I dug up the orchard to add even more blooms, later building greenhouses to further expand our growing possibilities. Eventually, the humble garden I planted for our family grew—with the help of my husband and kids—into a bustling 2-acre farm and design studio that supplied hundreds of thousands of flowers to markets, CSAs, and events. We later expanded into hosting intensive on-farm workshops focused on seasonal flower production and natural floral design.</p>
        <p class='content-4'>All of this led to my first book, Floret Farm’s Cut Flower Garden: Grow, Harvest & Arrange Stunning Seasonal Blooms, which gives step-by-step details on how to cultivate your own flowers in any size space.  The book features some of the most stunning varieties I’ve ever grown, which at the time weren’t available to home gardeners. But because I wanted readers to be able to grow the same flowers they saw in Cut Flower Garden, I decided to create our own line of Floret Seeds. In our online shop, we now offer seeds for many of my favorite varieties.</p>
        <p class='content-41'>And for those who are in search of local, seasonal flowers, we’ve developed a worldwide network of growers, Floret’s Farmer-Florist Collective, where you can find locally grown blooms, no matter where you live.</p>
    </div>
    <?php 
        include 'footer.php';
    ?>
</html>