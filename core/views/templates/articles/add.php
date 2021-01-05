<h1 class="text-center">New article</h1>
<div class="row justify-content-center">
    <div class="col-6">
        <form action="/article/add" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="text">Text:</label>
                <textarea name="text" id="text" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="user_id">Author:</label>
                <select name="user_id" id="user_id" class="form-control">
                    <?php foreach($users as $user):?>
                        <option value="<?= $user->id ?>"><?= $user->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <button class="btn btn-primary">Add</button>
        </form>
    </div>
</div>