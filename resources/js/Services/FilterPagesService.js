export default function FilterPagesService() {
  let elems = document.querySelectorAll(".js-delete");

  // на каждый элемент повесить обработчик на стадии перехвата
  for (let i = 0; i < elems.length; i++) {
    elems[i].addEventListener("click", function (event) {
      let message = event.target.dataset?.message
        ? event.target.dataset.message
        : "Вы действительно хотите удалить этот элемент?";
      if (confirm("Вы действительно хотите удалить этот элемент?")) {
        let form = document.createElement("form");
        form.action = event.target.dataset.action;
        form.method = "POST";
        form.style.display = "none";

        let token = document.createElement("input"),
          method = document.createElement("input");

        token.name = "_token";
        token.value = document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content");

        method.name = "_method";
        method.value = "DELETE";

        form.appendChild(token);
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
      }
    });
  }

  window.deleteImage = function (image) {
    if (confirm("Вы действительно хотите удалить это изображение?")) {
      let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      fetch("/admin/api/image/" + image, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-Token": token,
        },
      })
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          if (response.success)
            document.getElementById("image_" + image).remove();
        });
    }
  };

  let image_field = document.getElementsByClassName("js-autoload")[0];
  if (image_field) {
    image_field.addEventListener("change", (event) => {
      let form_data = new FormData();
      for (let i = 0; i < event.target.files.length; i++)
        form_data.append("image[]", event.target.files[i]);
      form_data.append("model_name", event.target.dataset.model);
      form_data.append("modelID", event.target.dataset.model_id);
      event.target.value = "";
      let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      fetch("/admin/upload_for", {
        method: "post",
        headers: {
          "X-CSRF-Token": token,
        },
        body: form_data,
      })
        .then((response) => response.json())
        .then((response) => {
          if (response.success) {
            let container = document.querySelector(".images");
            for (let i = 0; i < response.payload.images.length; i++) {
              let image = response.payload.images[i],
                col = document.createElement("div"),
                img = document.createElement("img"),
                btn_group = document.createElement("div");
              col.classList.add("col-12", "col-md-4", "mb-3");
              col.id = "image_" + image.id;
              img.src = "\\" + image.path;
              img.classList.add("img-fluid", "img-thumbnail");
              btn_group.classList.add(
                "btn-group",
                "btn-group-sm",
                "w-100",
                "mt-1"
              );
              btn_group.innerHTML = `
                    <button type="button" class="btn btn-danger" onclick="window.deleteImage(${image.id})">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>`;
              col.appendChild(img);
              col.appendChild(btn_group);
              container.prepend(col);
            }
          }
        });
    });
  }
}
