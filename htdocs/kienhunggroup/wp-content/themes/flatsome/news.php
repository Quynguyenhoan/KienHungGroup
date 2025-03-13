<?php
/*
Template Name: News
*/
?>

<?php get_header(); ?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .accordion-button {
            background-color: #FBAE3C;
            color: white;
            text-decoration: none;
        }
        .accordion-button:hover {
            background-color: #FBAE3C;
            opacity: 0.8;
        }
        .accordion-item .accordion-button {
            background-color: #FBAE3C;
            color: white;
        }
        .accordion-item .accordion-button:hover {
            background-color: #FFD966;
        }
        a{
            text-decoration: none;
        }
       .col-inner a {
            text-decoration: none;
        }
        .accordion-body .list-group-item {
  background-color: transparent;
  color: #333;
  transition: background-color 0.3s, color 0.3s;
}

.accordion-body .list-group-item:hover {
  background-color: #f1f1f1; /* Màu nền khi hover */
  color: #000; /* Màu chữ khi hover */
}
        .box{
            transition : opacity 0.6s ease ;
        }
        .ctn:hover > :not(:hover) {
opacity: 0.4;
        }
/* Tin tức đã chọn */
.selected-news-container {
        margin-top: 20px;
    }

    .selected-news-items {
        display: flex;
        flex-direction: column;
        gap: 10px; /* Khoảng cách giữa các mục tin tức */
    }

    .selected-news-item {
        display: flex;
        align-items: center;
        gap: 10px; /* Khoảng cách giữa ảnh và tiêu đề */
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 5px;
        background: #fff;
    }

    .selected-news-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .selected-news-item .post-title {
        font-size: 1rem;
        margin: 0;
    }
    /* Kích thước ảnh */
    #newsContent .col-inner {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

#newsContent .box-image {
    flex-shrink: 0;
}

#newsContent .image-cover img {
    object-fit: cover;
    width: 100%;
    height: 200px; /* Bạn có thể thay đổi chiều cao theo ý muốn */
}

/* Đảm bảo các phần tử text cũng được căn chỉnh và phân bổ không gian hợp lý */
#newsContent .box-text {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.footer {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}
    </style>
</head>


    <div class="container">
    <div class="news-page-title category-page-title dark featured-title page-title mb-3">
    <div class="page-title-bg fill">
        <div class="title-bg fill bg-fill parallax-active" data-parallax-fade="true" data-parallax="-2" data-parallax-background="" data-parallax-container=".page-title"></div>
        <div class="title-overlay fill"></div>
    </div>
    <div class="page-title-inner flex-row container medium-flex-wrap flex-has-center">
        <div class="flex-col">
            &nbsp;
        </div>
        <div class="flex-col flex-center text-center">
            <div class="is-medium">
            <nav class="woocommerce-breadcrumb breadcrumbs" id="breadcrumb">
         <a href="http://localhost/kienhunggroup/demowordpress">Trang chủ</a>
        <span class="divider">/</span>
       <a href="http://localhost/kienhunggroup/demowordpress/tin-tuc">Tin tức</a>
       <span class="divider">/</span>
        <span id="dynamic-breadcrumb"></span>
           </nav>
            </div>
      </div>
        <div class="flex-col flex-right text-right medium-text-center form-flat">
        <form class="woocommerce-ordering" method="get" id="orderbyForm">
    <select name="orderby" class="orderby" aria-label="Sắp xếp tin tức">
        <option value="">Mặc định</option>
        <option value="random">Ngẫu nhiên</option>
        <option value="newest">Mới nhất</option>
    </select>
    <input type="hidden" name="paged" value="1">
       </form>

</div>
    </div>
    </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm...">
                </div>
                <div class="mb-3">
                    <h5>Danh mục tin tức</h5>
                    <div class="accordion" id="categoryAccordion">
                        <?php
                        global $wpdb;
                        $news_table = 'news_category';
                        $parent_categories = $wpdb->get_results("SELECT * FROM $news_table WHERE parent_category_id IS NULL");

                        if ($wpdb->last_error) {
                            echo "Lỗi: " . $wpdb->last_error;
                        }

                        foreach ($parent_categories as $parent_category) :
                            $child_categories = $wpdb->get_results($wpdb->prepare("SELECT * FROM $news_table WHERE parent_category_id = %d", $parent_category->Id));
                        ?>
<div class="accordion-item">
        <h2 class="accordion-header" id="heading<?php echo $parent_category->Id; ?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $parent_category->Id; ?>" aria-expanded="true" data-category-id="<?php echo $parent_category->Id; ?>" aria-controls="collapse<?php echo $parent_category->Id; ?>" data-icon="<?php echo $parent_category->Icon; ?>">
                <?php echo $parent_category->category_title; ?>
            </button>
        </h2>
        <div id="collapse<?php echo $parent_category->Id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $parent_category->Id; ?>" data-bs-parent="#categoryAccordion">
            <div class="accordion-body">
                <ul class="list-group">
                    <?php foreach ($child_categories as $child_category) : ?>
                        <li class="list-group-item" data-category="<?php echo $child_category->Id; ?>" data-parent-category="<?php echo $parent_category->Id; ?>" data-icon="<?php echo $child_category->Icon; ?>">
                            <?php echo $child_category->category_title; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach; ?>                    </div>
                </div>
                <!-- Vùng hiển thị tin tức đã chọn -->
        <div id="selected-news-container" class="selected-news-container">
            <div id="selected-news-items" class="selected-news-items"></div>
        </div>
            </div>

            <div class="col-lg-8" id="newsContent">
                <div class="mb-3">
                    <h5>Danh sách tin tức</h5>
                    <div id="row-news" class="row ctn row-cols-1 row-cols-md-3 g-2 large-columns-3 medium-columns- small-columns-1 has-shadow row-box-shadow-2 row-box-shadow-1-hover row-masonry" data-packery-options='{"itemSelector": ".col", "gutter": 0, "presentageWidth" : true}'>
    <?php
    global $wpdb;
    $news_table = 'news';
    $news_data = $wpdb->get_results("SELECT * FROM $news_table WHERE IsActive = 1");

    if ($wpdb->last_error) {
        echo "Lỗi: " . $wpdb->last_error;
    }

    foreach ($news_data as $news) :
    ?>

<div class="col box post-item" data-id="<?php echo $news->Id; ?>" data-title="<?php echo htmlspecialchars($news->Title); ?>" data-image="<?php echo $news->News_image; ?>" data-category="<?php echo $news->News_Category_id; ?>" data-parent-category="<?php echo $news->Parent_Category_id; ?>" data-created-date="<?php echo $news->CreatedDate; ?>">
            <div class="col-inner">
                <a href="/kienhunggroup/demowordpress/chi-tiet-tin-tuc/?news_id=<?php echo $news->Id; ?>" class="plain news-link">
                    <div class="box box-text-bottom box-blog-post has-hover">
                        <div class="box-image">
                            <div class="image-cover" style="padding-top:56%;">
                                <img width="600px" height="385px" src="<?php echo $news->News_image; ?>" class="attachment-medium size-medium wp-post-image" alt="<?php echo $news->Title; ?>" />
                            </div>
                        </div>
                        <div class="box-text text-left">
                            <div class="box-text-inner blog-post-inner">
                                <h5 class="post-title is-large post-title"><?php echo $news->Title; ?></h5>
                                <div class="is-divider"></div>
                                <p class="from_the_blog_excerpt"><?php echo wp_trim_words($news->News_Description,5, '...'); ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
              
    

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script>
       document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const newsList = document.getElementById("row-news");

    // Lắng nghe sự kiện khi nhập liệu vào ô tìm kiếm
    searchInput.addEventListener("input", function() {
        filterNewsByTitle(this.value.toLowerCase());
    });

    // Lắng nghe sự kiện khi nhấp vào một danh mục tin tức
    document.getElementById("categoryAccordion").addEventListener("click", function(e) {
        if (e.target.tagName === "LI") {
            const categoryId = e.target.getAttribute("data-category").toLowerCase();
            filterNewsByCategory(categoryId);
            updateBreadcrumb(e.target.textContent.trim());
        }
    });

    // Hàm lọc tin tức theo tiêu đề
    function filterNewsByTitle(title) {
        const newsItems = newsList.querySelectorAll(".col.post-item");
        newsItems.forEach(function(news) {
            const newsTitle = news.textContent.toLowerCase();
            if (newsTitle.includes(title)) {
                news.style.display = "block";
            } else {
                news.style.display = "none";
            }
        });
    }

    // Hàm lọc tin tức theo danh mục
    function filterNewsByCategory(categoryId) {
        const newsItems = newsList.querySelectorAll(".col.post-item");
        newsItems.forEach(function(news) {
            const newsCategory = news.getAttribute("data-category");
            if (categoryId === "" || newsCategory === categoryId) {
                news.style.display = "block";
            } else {
                news.style.display = "none";
            }
        });
    }

    // Hàm cập nhật breadcrumb
    function updateBreadcrumb(selectedCategoryTitle) {
        const parentCategoryButton = document.querySelector(".accordion-button[aria-expanded='true']");
        const parentCategoryTitle = parentCategoryButton ? parentCategoryButton.textContent.trim() : "";

        const breadcrumbHtml = `
            <a href="#">${parentCategoryTitle}</a>
            <span class="divider">/</span>
            <span>${selectedCategoryTitle}</span>
        `;
        document.getElementById('dynamic-breadcrumb').innerHTML = breadcrumbHtml;
    }

    // Sắp xếp tin tức
    const orderByForm = document.getElementById("orderbyForm");
    const orderBySelect = orderByForm.querySelector(".orderby");
    // Lấy giá trị sắp xếp từ localStorage nếu có
    const savedOrderBy = localStorage.getItem('orderby');
    if (savedOrderBy) {
        orderBySelect.value = savedOrderBy;
        applySorting(savedOrderBy);
    }
    // Lắng nghe sự kiện thay đổi sắp xếp
    orderBySelect.addEventListener("change", function(event) {
        event.preventDefault();
        const selectedValue = this.value;
        localStorage.setItem('orderby', selectedValue);
        applySorting(selectedValue);
    });
    // Hàm áp dụng sắp xếp
    function applySorting(sortType) {
        if (sortType === 'newest') {
            sortNewsByNewest();
        } else if (sortType === 'random') {
            sortNewsRandomly();
        } else {
            showDefaultNews();
        }
    }
    // Hàm sắp xếp tin tức mới nhất
    function sortNewsByNewest() {
        const newsContainer = document.getElementById("row-news");
        const newsItems = Array.from(newsContainer.getElementsByClassName("post-item"));
        newsItems.sort(function(a, b) {
            const createdDateA = new Date(a.getAttribute("data-created-date"));
            const createdDateB = new Date(b.getAttribute("data-created-date"));
            return createdDateB - createdDateA;
        });
        newsContainer.innerHTML = '';
        newsItems.forEach(function(news) {
            newsContainer.appendChild(news);
        });
    }
    // Hàm sắp xếp tin tức ngẫu nhiên
    function sortNewsRandomly() {
        const newsContainer = document.getElementById("row-news");
        const newsItems = Array.from(newsContainer.getElementsByClassName("post-item"));
        newsItems.sort(() => Math.random() - 0.5);
        newsContainer.innerHTML = '';
        newsItems.forEach(function(news) {
            newsContainer.appendChild(news);
        });
    }
    // Hàm hiển thị tin tức mặc định
    function showDefaultNews() {
        const newsContainer = document.getElementById("row-news");
        const newsItems = Array.from(newsContainer.getElementsByClassName("post-item"));
        newsItems.sort(function(a, b) {
            return a.getAttribute("data-original-order") - b.getAttribute("data-original-order");
        });
        newsContainer.innerHTML = '';
        newsItems.forEach(function(news) {
            newsContainer.appendChild(news);
        });
    }
    // Lưu thứ tự ban đầu của các tin tức
    function saveOriginalOrder() {
        const newsItems = document.querySelectorAll(".post-item");
        newsItems.forEach((news, index) => {
            news.setAttribute("data-original-order", index);
        });
    }
    
    // Tin tức đã chọn
    const newsLinks = document.querySelectorAll(".news-link");
    const selectedNewsContainer = document.getElementById("selected-news-items");
    loadSelectedNews();

    newsLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            const newsItem = this.closest(".post-item");
            const newsId = newsItem.getAttribute("data-id");
            const newsTitle = newsItem.getAttribute("data-title");
            const newsImage = newsItem.getAttribute("data-image");
            saveSelectedNews(newsId, newsTitle, newsImage);
            loadSelectedNews();
        });
    });
    // Hàm lưu tin tức đã chọn vào localStorage
    function saveSelectedNews(id, title, image) {
        let selectedNews = JSON.parse(localStorage.getItem('selectedNews')) || [];
        if (!selectedNews.some(news => news.id === id)) {
            selectedNews.push({ id, title, image });
        }
        if (selectedNews.length > 3) {
            selectedNews.shift();
        }
        localStorage.setItem('selectedNews', JSON.stringify(selectedNews));
    }
    // Hàm tải tin tức đã chọn từ localStorage
    function loadSelectedNews() {
        let selectedNews = JSON.parse(localStorage.getItem('selectedNews')) || [];
        renderSelectedNews(selectedNews);
    }
    // Hàm hiển thị tin tức đã chọn
    function renderSelectedNews(newsItems) {
        selectedNewsContainer.innerHTML = '';

        // Tạo phần tử tiêu đề cho danh sách tin tức đã chọn
        const widgetTitle = document.createElement("span");
        widgetTitle.classList.add("widget-title", "shop-sidebar");
        widgetTitle.textContent = "Tin tức bạn quan tâm";
        selectedNewsContainer.appendChild(widgetTitle);

        // Tạo phần tử chứa tin tức đã chọn
        const newsContainer = document.createElement("div");
        newsContainer.classList.add("selected-news-container");
        selectedNewsContainer.appendChild(newsContainer);

        // Thêm mỗi tin tức đã chọn vào phần tử tin tức đã chọn
        newsItems.forEach(news => {
            const newsItem = document.createElement("div");
            newsItem.classList.add("selected-news-item");

            const link = document.createElement("a");
            link.href = `/kienhunggroup/demowordpress/chi-tiet-tin-tuc/?news_id=${news.id}`;

            const image = document.createElement("img");
            image.src = news.image;
            image.alt = news.title;

            const title = document.createElement("span");
            title.classList.add("post-title");
            title.textContent = news.title;
            title.style.marginLeft = "5px";

            link.appendChild(image);
            link.appendChild(title);

            newsItem.appendChild(link);
            newsContainer.appendChild(newsItem);
        });
    }
});

                     
                        // Background image danh mục 
 document.addEventListener("DOMContentLoaded", function() {
    // bổ sung background image
    function updateBackground(iconUrl) {
        const backgroundElement = document.querySelector('.page-title-bg .title-bg');
        backgroundElement.style.backgroundImage = `url(${iconUrl})`;
    }

    // Danh mục cha background
    document.querySelectorAll(".accordion-button").forEach(button => {
        button.addEventListener("click", function() {
            const iconUrl = this.getAttribute("data-icon");
            updateBackground(iconUrl);
        });
    });

    // Danh mục con background
    document.querySelectorAll(".list-group-item").forEach(item => {
        item.addEventListener("click", function() {
            const iconUrl = this.getAttribute("data-icon");
            updateBackground(iconUrl);
        });
    });
});

// Danh mục cha 
    document.addEventListener('DOMContentLoaded', function() {
    var newsItems = document.querySelectorAll('#row-news .col');
    var selectedNewsItems = document.getElementById('selected-news-items');
    var categoryAccordion = document.getElementById('categoryAccordion');

    // Lấy tất cả các danh mục con của danh mục cha
    function getChildCategories(parentCategoryId) {
        var childCategories = [];
        var childCategoryElements = categoryAccordion.querySelectorAll('[data-parent-category="' + parentCategoryId + '"]');
        childCategoryElements.forEach(function(element) {
            childCategories.push(element.getAttribute('data-category'));
        });
        return childCategories;
    }

    // Cập nhật danh sách tin tức dựa trên danh mục đã chọn
    function updateNewsList(categoryId, categoryName, isParentCategory) {
        newsItems.forEach(function(newsItem) {
            var newsCategoryId = newsItem.getAttribute('data-category');
            var newsParentCategoryId = newsItem.getAttribute('data-parent-category');
            var isVisible = false;

            // Nếu là danh mục cha, hiển thị các tin tức thuộc danh mục cha và danh mục con
            if (isParentCategory) {
                var childCategories = getChildCategories(categoryId);
                isVisible = (newsParentCategoryId == categoryId) || (childCategories.includes(newsCategoryId));
            } else {
                isVisible = (newsCategoryId == categoryId);
            }

            newsItem.style.display = isVisible ? 'block' : 'none';
        });

        dynamicBreadcrumb.textContent = categoryName;
        selectedCategoryId = categoryId;
        clearSelectedNewsItems();
    }

    // Xử lý sự kiện click vào danh mục cha
    categoryAccordion.addEventListener('click', function(event) {
        var target = event.target;

        if (target.classList.contains('accordion-button')) {
            var categoryId = target.getAttribute('data-category-id');
            var categoryName = target.textContent.trim();
            updateNewsList(categoryId, categoryName, true);
        } 
    });

});


    </script>
                  </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
