<h2 class="text-center">Import products</h2>

<form enctype="multipart/form-data"
      action="/load" 
      method="POST"       
      class="formaDowloadProd">

    <span>Choose catalog for import products:</span>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> 
    <input type="file" name="file" id="file">  
    <!-- <input type="hidden" name="action" value="uploadFile">   -->
    <button class="btn btn-primary">Add products</button>
    <!-- <input type="submit" value="Add products" /> -->
</form>
