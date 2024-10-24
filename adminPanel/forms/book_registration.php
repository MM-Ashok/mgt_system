<fieldset>
    <div class="form-group">
        <label for="title">Title </label>
          <input type="text" name="title" value="<?php echo htmlspecialchars($edit ? $customer['title'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Title" class="form-control" required="required" id = "title" >
    </div> 

    <div class="form-group">
        <label for="author">Author </label>
        <input type="text" name="author" value="<?php echo htmlspecialchars($edit ? $customer['author'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Author" class="form-control" required="required" id="author">
    </div> 

    <div class="form-group">
        <label for="isbn">ISBN</label>
          <textarea name="isbn" placeholder="isbn" class="form-control" id="isbn"><?php echo htmlspecialchars(($edit) ? $customer['isbn'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 

    <div class="form-group">
        <label for="category">Category</label>
          <textarea name="category" placeholder="category" class="form-control" id="category"><?php echo htmlspecialchars(($edit) ? $customer['category'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 
           
    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div> 
</fieldset>
