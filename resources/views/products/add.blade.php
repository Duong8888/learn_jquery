<div class="col-md-12 d-flex justify-content-center position-fixed top-0 p-4 custom-popup">
    <div class="card col-md-6 card-form">
        <div class="card-body">
            <div class="basic-form">
                <form class="form-add-product">
                    <div class="row">
                        @csrf
                        <div class="form-group col-md-6">
                            <label>Product name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Tomato...">
                            <span class="error text-danger"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Price <span class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control" name="price" placeholder="999">
                            <span class="error text-danger"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Status <span class="text-danger">*</span></label>
                            <select id="inputState" class="form-control" name="status" tabindex="null">
                                <option >Choose...</option>
                                <option class="opt" value="2">Successful</option>
                                <option class="opt" value="0">Canceled</option>
                                <option class="opt" value="1">Pending</option>
                            </select>
                            <span class="error text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="8" id="comment"></textarea>
                            <span class="error text-danger"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnSubmit">Add</button>
                    <button type="button" class="btn btn-dark" id="btn-cancel">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
