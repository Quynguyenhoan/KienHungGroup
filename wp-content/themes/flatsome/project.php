<?php
/*
Template Name: Trang dự án 
*/

get_header(); 
?>
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
/* Dự án đã chọn */
.selected-project-container {
        margin-top: 20px;
    }

    .selected-project-items {
        display: flex;
        flex-direction: column;
        gap: 10px; /* Khoảng cách giữa các mục Dự án */
    }

    .selected-project-item {
        display: flex;
        align-items: center;
        gap: 10px; /* Khoảng cách giữa ảnh và tiêu đề */
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 5px;
        background: #fff;
    }

    .selected-project-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .selected-project-item .post-title {
        font-size: 1rem;
        margin: 0;
    }
    /* Kích thước ảnh */
    #projectContent .col-inner {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    padding: 10px;
}

#projectContent .box-image {
    flex-shrink: 0;
}

#projectContent .image-cover img {
    object-fit: cover;
    width: 100%;
    height: 200px;
    border-radius: 10px;
}

#projectContent .box-text {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 10px;
}

.hover-1 img {
    width: 105%;
    position: absolute;
    top: 0;
    left: -5%;
    transition: all 0.3s;
    border-radius: 10px;
}


.hover-1 .hover-overlay {
    background: rgba(0, 0, 0, 0.5);
    transition: opacity 0.4s;
}

.hover-1:hover .hover-1-content {
    bottom: 2rem;
}

.hover-1:hover .hover-1-description {
    opacity: 1;
    transform: none;
}

.hover-1:hover img {
    left: 0;
}

.hover-1:hover .hover-overlay {
    opacity: 0;
}

.hover {
    overflow: hidden;
    position: relative;
    padding-bottom: 60%;
}

.hover-overlay {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 90;
    transition: all 0.4s;
}

.hover img {
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    transition: all 0.3s;
    border-radius: 10px;
}

.hover-content {
    position: relative;
    z-index: 99;
}

.hover-1-content {
    position: absolute;
    bottom: 0;
    left: 0;
    z-index: 99;
    transition: all 0.4s;
    padding: 0 5px; /* Thêm khoảng cách giữa nội dung và ảnh */
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
    <div class="project-page-title category-page-title dark featured-title page-title mb-3">
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
       <a href="http://localhost/kienhunggroup/demowordpress/du-an">Dự án</a>
       <span class="divider">/</span>
        <span id="dynamic-breadcrumb"></span>
           </nav>
            </div>
      </div>
        <div class="flex-col flex-right text-right medium-text-center form-flat">
        <form class="woocommerce-ordering" method="get" id="orderbyForm">
    <select name="orderby" class="orderby" aria-label="Sắp xếp Dự án">
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
                    <h5>Danh mục Dự án</h5>
                    <div class="accordion" id="categoryAccordion">
                        <?php
                        global $wpdb;
                        $project_table = 'project_category';
                        $parent_categories = $wpdb->get_results("SELECT * FROM $project_table WHERE parent_category_id IS NULL");

                        if ($wpdb->last_error) {
                            echo "Lỗi: " . $wpdb->last_error;
                        }

                        foreach ($parent_categories as $parent_category) :
                            $child_categories = $wpdb->get_results($wpdb->prepare("SELECT * FROM $project_table WHERE parent_category_id = %d", $parent_category->Id));
                        ?>
<div class="accordion-item">
        <h2 class="accordion-header" id="heading<?php echo $parent_category->Id; ?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $parent_category->Id; ?>" aria-expanded="true" data-category-id="<?php echo $parent_category->Id; ?>" aria-controls="collapse<?php echo $parent_category->Id; ?>" data-icon="<?php echo $parent_category->Icon; ?>">
                <?php echo $parent_category->Title; ?>
            </button>
        </h2>
        <div id="collapse<?php echo $parent_category->Id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $parent_category->Id; ?>" data-bs-parent="#categoryAccordion">
            <div class="accordion-body">
                <ul class="list-group">
                    <?php foreach ($child_categories as $child_category) : ?>
                        <li class="list-group-item" data-category="<?php echo $child_category->Id; ?>" data-parent-category="<?php echo $parent_category->Id; ?>" data-icon="<?php echo $child_category->Icon; ?>">
                            <?php echo $child_category->Title; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach; ?>                    </div>
                </div>
                <!-- Vùng hiển thị Dự án đã chọn -->
        <div id="selected-project-container" class="selected-project-container">
            <div id="selected-project-items" class="selected-project-items"></div>
        </div>
            </div>

            <div class="col-lg-8" id="projectContent">
    <div class="mb-3">
        <h5>Danh sách Dự án</h5>
        <div id="row-project" class="row large-columns-2 small-columns-1 row-cols-1 row-cols-sm-2 row-cols-lg-2 g-3">
            <?php
            global $wpdb;
            $project_table = 'project';
            $project_data = $wpdb->get_results("SELECT * FROM $project_table");

            if ($wpdb->last_error) {
                echo "Lỗi: " . $wpdb->last_error;
            }

            foreach ($project_data as $project) :
            ?>
            <div class="col post-item" data-id="<?php echo $project->Id; ?>" data-title="<?php echo htmlspecialchars($project->TenDuAn); ?>" data-image="<?php echo $project->project_image_c; ?>" data-category="<?php echo $project->ProjectCategory_id; ?>" data-parent-category="<?php echo $project->parent_category_id; ?>" data-created-date="<?php echo $project->CreatedDate; ?>">
                <div class="col-inner">
                    <a href="/kienhunggroup/demowordpress/chi-tiet-du-an/?project_id=<?php echo $project->Id; ?>" class="plain project-link">
                        <div class="hover hover-1 text-white rounded">
                            <img src="<?php echo $project->project_image_c; ?>" alt="<?php echo $project->TenDuAn; ?>">
                            <div class="hover-overlay"></div>
                            <div class="hover-1-content px-5 py-4">
                                <h3 class="hover-1-title text-uppercase font-weight-bold mb-0">
                                    <span class="font-weight-light"><?php echo $project->TenDuAn; ?></span>
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

    
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script>
       document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const projectList = document.getElementById("row-project");

    // Lắng nghe sự kiện khi nhập liệu vào ô tìm kiếm
    searchInput.addEventListener("input", function() {
        filterprojectByTitle(this.value.toLowerCase());
    });

    // Lắng nghe sự kiện khi nhấp vào một danh mục Dự án
    document.getElementById("categoryAccordion").addEventListener("click", function(e) {
        if (e.target.tagName === "LI") {
            const categoryId = e.target.getAttribute("data-category").toLowerCase();
            filterprojectByCategory(categoryId);
            updateBreadcrumb(e.target.textContent.trim());
        }
    });

    // Hàm lọc Dự án theo tiêu đề
    function filterprojectByTitle(title) {
        const projectItems = projectList.querySelectorAll(".col.post-item");
        projectItems.forEach(function(project) {
            const projectTitle = project.textContent.toLowerCase();
            if (projectTitle.includes(title)) {
                project.style.display = "block";
            } else {
                project.style.display = "none";
            }
        });
    }

    // Hàm lọc Dự án theo danh mục
    function filterprojectByCategory(categoryId) {
        const projectItems = projectList.querySelectorAll(".col.post-item");
        projectItems.forEach(function(project) {
            const projectCategory = project.getAttribute("data-category");
            if (categoryId === "" || projectCategory === categoryId) {
                project.style.display = "block";
            } else {
                project.style.display = "none";
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

    // Sắp xếp Dự án
    const orderByForm = document.getElementById("orderbyForm");
    const orderBySelect = orderByForm.querySelector(".orderby");

    const savedOrderBy = localStorage.getItem('orderby');
    if (savedOrderBy) {
        orderBySelect.value = savedOrderBy;
        applySorting(savedOrderBy);
    }
//   Lắng nghe sự kiện thay đổi sắp xếp
    orderBySelect.addEventListener("change", function(event) {
        event.preventDefault();
        const selectedValue = this.value;
        localStorage.setItem('orderby', selectedValue);
        applySorting(selectedValue);
    });
//  Hàm áp dụng sắp xếp
    function applySorting(sortType) {
        if (sortType === 'newest') {
            sortprojectByNewest();
        } else if (sortType === 'random') {
            sortprojectRandomly();
        } else {
            showDefaultproject();
        }
    }
// Hiển thị dự án mới nhất
    function sortprojectByNewest() {
        const projectContainer = document.getElementById("row-project");
        const projectItems = Array.from(projectContainer.getElementsByClassName("post-item"));
        projectItems.sort(function(a, b) {
            const createdDateA = new Date(a.getAttribute("data-created-date"));
            const createdDateB = new Date(b.getAttribute("data-created-date"));
            return createdDateB - createdDateA;
        });
        projectContainer.innerHTML = '';
        projectItems.forEach(function(project) {
            projectContainer.appendChild(project);
        });
    }
// Hiển thị dự án ngẫn nhiên
    function sortprojectRandomly() {
        const projectContainer = document.getElementById("row-project");
        const projectItems = Array.from(projectContainer.getElementsByClassName("post-item"));
        projectItems.sort(() => Math.random() - 0.5);
        projectContainer.innerHTML = '';
        projectItems.forEach(function(project) {
            projectContainer.appendChild(project);
        });
    }
// Hàm hiển thị dự án mặc định 
    function showDefaultproject() {
        const projectContainer = document.getElementById("row-project");
        const projectItems = Array.from(projectContainer.getElementsByClassName("post-item"));
        projectItems.sort(function(a, b) {
            return a.getAttribute("data-original-order") - b.getAttribute("data-original-order");
        });
        projectContainer.innerHTML = '';
        projectItems.forEach(function(project) {
            projectContainer.appendChild(project);
        });
    }
// Lưu thứ tự ban đầu của các dự án
    function saveOriginalOrder() {
        const projectItems = document.querySelectorAll(".post-item");
        projectItems.forEach((project, index) => {
            project.setAttribute("data-original-order", index);
        });
    }
    
    // Dự án đã chọn
    const projectLinks = document.querySelectorAll(".project-link");
    const selectedprojectContainer = document.getElementById("selected-project-items");
    loadSelectedproject();

    projectLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            const projectItem = this.closest(".post-item");
            const projectId = projectItem.getAttribute("data-id");
            const projectTitle = projectItem.getAttribute("data-title");
            const projectImage = projectItem.getAttribute("data-image");
            saveSelectedproject(projectId, projectTitle, projectImage);
            loadSelectedproject();
        });
    });
 // Hàm lưu dự án đã chọn vào localStorage
    function saveSelectedproject(id, title, image) {
        let selectedproject = JSON.parse(localStorage.getItem('selectedproject')) || [];
        if (!selectedproject.some(project => project.id === id)) {
            selectedproject.push({ id, title, image });
        }
        if (selectedproject.length > 3) {
            selectedproject.shift();
        }
        localStorage.setItem('selectedproject', JSON.stringify(selectedproject));
    }
// Hàm tải dự án đã chọn từ localStorage
    function loadSelectedproject() {
        let selectedproject = JSON.parse(localStorage.getItem('selectedproject')) || [];
        renderSelectedproject(selectedproject);
    }
// Hàm hiển thị dự án đã chọn
    function renderSelectedproject(projectItems) {
        selectedprojectContainer.innerHTML = '';

        // Tạo phần tử tiêu đề cho danh sách Dự án đã chọn
        const widgetTitle = document.createElement("span");
        widgetTitle.classList.add("widget-title", "shop-sidebar");
        widgetTitle.textContent = "Dự án bạn quan tâm";
        selectedprojectContainer.appendChild(widgetTitle);

        // Tạo phần tử chứa Dự án đã chọn
        const projectContainer = document.createElement("div");
        projectContainer.classList.add("selected-project-container");
        selectedprojectContainer.appendChild(projectContainer);

        // Thêm mỗi Dự án đã chọn vào phần tử Dự án đã chọn
        projectItems.forEach(project => {
            const projectItem = document.createElement("div");
            projectItem.classList.add("selected-project-item");

            const link = document.createElement("a");
            link.href = `/kienhunggroup/demowordpress/chi-tiet-du-an/?project_id=${project.id}`;

            const image = document.createElement("img");
            image.src = project.image;
            image.alt = project.title;
            image.classList.add("project-image"); // Thêm lớp CSS cho ảnh

            const title = document.createElement("span");
            title.classList.add("post-title");
            title.textContent = project.title;
            title.classList.add("project-title"); // Thêm lớp CSS cho tiêu đề

// Áp dụng CSS để tạo khoảng cách giữa ảnh và chữ
title.style.marginLeft = "5px"; // Hoặc title.classList.add("title-margin")
            link.appendChild(image);
            link.appendChild(title);

            projectItem.appendChild(link);
            projectContainer.appendChild(projectItem);
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
    var projectItems = document.querySelectorAll('#row-project .col');
    var selectedprojectItems = document.getElementById('selected-project-items');
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

    // Cập nhật danh sách Dự án dựa trên danh mục đã chọn
    function updateprojectList(categoryId, categoryName, isParentCategory) {
        projectItems.forEach(function(projectItem) {
            var projectCategoryId = projectItem.getAttribute('data-category');
            var projectParentCategoryId = projectItem.getAttribute('data-parent-category');
            var isVisible = false;

            // Nếu là danh mục cha, hiển thị các Dự án thuộc danh mục cha và danh mục con
            if (isParentCategory) {
                var childCategories = getChildCategories(categoryId);
                isVisible = (projectParentCategoryId == categoryId) || (childCategories.includes(projectCategoryId));
            } else {
                isVisible = (projectCategoryId == categoryId);
            }

            projectItem.style.display = isVisible ? 'block' : 'none';
        });

    }
    // Xử lý sự kiện click vào danh mục cha
    categoryAccordion.addEventListener('click', function(event) {
        var target = event.target;

        if (target.classList.contains('accordion-button')) {
            var categoryId = target.getAttribute('data-category-id');
            var categoryName = target.textContent.trim();
            updateprojectList(categoryId, categoryName, true);
        } 
    });

});
    </script>
           
<?php get_footer();
