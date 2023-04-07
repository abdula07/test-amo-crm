<div class="container">
    <div class="col m-5">
        <h1>Создание сделки</h1>
        <form action="/" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input required type="text" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name"
                       placeholder="Aziz">
                <div class="invalid-feedback">
                    <?= $errors['name'] ?? '' ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input required type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" placeholder="name@example.com">
                <div class="invalid-feedback">
                    <?= $errors['email'] ?? '' ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Телефон</label>
                <input required type="text" name="phone" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" id="phone" placeholder="+79505152438">
                <div class="invalid-feedback">
                    <?= $errors['phone'] ?? '' ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Цена</label>
                <input required type="number" name="price" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" id="price" placeholder="100">
                <div class="invalid-feedback">
                    <?= $errors['price'] ?? '' ?>
                </div>
            </div>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
            <input type="submit" class="btn btn-primary">
        </form>
    </div>
</div>