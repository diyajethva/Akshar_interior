<?php

include("includes/db.php");

/* Original six services */
$services = [
    ["service_name" => "Home Interior", "icon" => "fa-solid fa-house", "description" => "Luxury home interiors with modern and elegant designs."],
    ["service_name" => "Modular Kitchen", "icon" => "fa-solid fa-kitchen-set", "description" => "Beautiful modular kitchens with smart storage solutions."],
    ["service_name" => "Bedroom Design", "icon" => "fa-solid fa-bed", "description" => "Comfortable and luxurious bedroom interiors."],
    ["service_name" => "Living Room", "icon" => "fa-solid fa-couch", "description" => "Modern living room concepts with premium finishing."],
    ["service_name" => "Office Interior", "icon" => "fa-solid fa-building", "description" => "Professional office interiors for productive workplaces."],
    ["service_name" => "TV Unit & Wardrobe", "icon" => "fa-solid fa-tv", "description" => "Custom TV units and wardrobes with stylish finishes."]
];

/* Get services added/edited from Admin Panel */
$db_result = mysqli_query(
    $conn,
    "SELECT service_name, icon, description FROM services ORDER BY id ASC"
);

if ($db_result) {
    while ($row = mysqli_fetch_assoc($db_result)) {
        $name = trim($row["service_name"] ?? "");
        if ($name === "") {
            continue;
        }

        $found = false;

        foreach ($services as $i => $service) {
            if (strcasecmp($service["service_name"], $name) === 0) {
                $services[$i]["service_name"] = $name;
                if (trim($row["icon"] ?? "") !== "") {
                    $services[$i]["icon"] = trim($row["icon"]);
                }
                if (trim($row["description"] ?? "") !== "") {
                    $services[$i]["description"] = trim($row["description"]);
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            $services[] = [
                "service_name" => $name,
                "icon" => trim($row["icon"] ?? "fa-solid fa-star"),
                "description" => trim($row["description"] ?? "")
            ];
        }
    }
}

include("includes/header.php");
?>

<!-- SERVICES PAGE BANNER -->
<section style="height:55vh;min-height:500px;position:relative;overflow:hidden;display:flex;align-items:center;">
    <img src="assets/images/about_page.jpeg" alt="Akshar Interior Services" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;object-position:center;z-index:0;">

    <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.62);z-index:1;"></div>

    <div class="container" style="position:relative;z-index:2;width:100%;">
        <div data-aos="fade-right" style="max-width:750px;">
            <h1 style="color:#ffffff;font-size:60px;line-height:1.1;margin:0 0 20px 0;">
                Our <span style="color:#D4AF37;">Services</span>
            </h1>
            <p style="color:#ffffff;font-size:19px;line-height:1.7;margin:0;max-width:650px;">
                Premium Interior Design Solutions For Homes, Offices And Commercial Spaces.
            </p>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section class="services">
    <div class="container">
        <div class="section-title">
            <h2>Our Premium Services</h2>
            <p>Elegant Interior Solutions Designed For Every Space</p>
        </div>

        <div class="service-grid">
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    <h3><?php echo htmlspecialchars($service['service_name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="about">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose Us?</h2>
        </div>

        <div class="service-grid">
            <div class="service-card">
                <i class="fa-solid fa-award"></i>
                <h3>Premium Quality</h3>
                <p>High-quality materials and excellent finishing.</p>
            </div>

            <div class="service-card">
                <i class="fa-solid fa-users"></i>
                <h3>Expert Designers</h3>
                <p>Experienced and creative interior professionals.</p>
            </div>

            <div class="service-card">
                <i class="fa-solid fa-clock"></i>
                <h3>On-Time Delivery</h3>
                <p>We always complete projects on schedule.</p>
            </div>
        </div>
    </div>
</section>

<style>
@media(max-width:768px){
    .services-page-banner-content h1{font-size:42px;}
}
</style>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({duration:1000, once:true});
</script>

<?php include("includes/footer.php"); ?>
