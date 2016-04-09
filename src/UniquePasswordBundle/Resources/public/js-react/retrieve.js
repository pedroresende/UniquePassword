var Content = React.createClass({
  render: function() {
      var view = "/password/view/" + this.props.content.id;
      var edit = "/password/edit/" + this.props.content.id;
      var remove = "/password/delete/" + this.props.content.id;
    return (
        <tr role="row" className="even">
            <td className="sorting_1">{this.props.content.category}</td>
            <td>{this.props.content.name}</td>
            <td>{this.props.content.modified}</td>
            <td>{this.props.content.created}</td>
            <td>
                <a href={view} className="btn btn-sm btn-primary">View</a>&nbsp;
                <a href={edit} className="btn btn-sm btn-info">Edit</a>&nbsp;
                <a href={remove} className="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
    );
  }
});


var ListContent = React.createClass({
    render: function() {
        var Contents = this.props.data.map(function(content) {
            return (
                <Content content={content} key={content.id}>
                  {content.name}
                </Content>
            );
        });
        return (
            <tbody>
                {Contents}
            </tbody>
        );
    }
});

var PasswordContent = React.createClass({
    getInitialState: function () {
        return {
            data: [],
            contentState: "1"
        };
    },
    componentDidMount: function () {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({data: data});
            }.bind(this),
            error: function(data, status, err) {
                console.log(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    render: function () {
        var results = this.state.data.length;
        return (
            <div className="box">
                <div className="box-header">
                    <h3 className="box-title">Data Table With Full Features</h3>
                </div>
                <div className="box-body">
                    <div id="example1_wrapper" className="dataTables_wrapper form-inline dt-bootstrap">
                        <div className="row">
                            <div className="col-sm-6">
                                <div className="dataTables_length" id="example1_length">
                                    <label>Show 
                                        <select name="example1_length" aria-controls="example1" className="form-control input-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label>
                                </div>
                            </div>
                            <div className="col-sm-6">
                                <div id="example1_filter" className="dataTables_filter">
                                    <label>Search:
                                        <input type="search" className="form-control input-sm" placeholder="" aria-controls="example1" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-sm-12">
                                <table id="example1" className="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th className="sorting_asc" tabIndex="0" aria-controls="example1" rowSpan="1" colSpan="1" aria-sort="ascending" aria-label="Category: activate to sort column descending">Category</th>
                                            <th className="sorting" tabIndex="0" aria-controls="example1" rowSpan="1" colSpan="1" aria-label="Name: activate to sort column ascending">Name</th>
                                            <th className="sorting" tabIndex="0" aria-controls="example1" rowSpan="1" colSpan="1" aria-label="Modified: activate to sort column ascending">Modified</th>
                                            <th className="sorting" tabIndex="0" aria-controls="example1" rowSpan="1" colSpan="1" aria-label="Created: activate to sort column ascending">Created</th>
                                            <th className="sorting" tabIndex="0" aria-controls="example1" rowSpan="1" colSpan="1" aria-label="Options: activate to sort column ascending">Options</th>
                                        </tr>
                                    </thead>
                                    <ListContent data={this.state.data} />
                                </table>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-sm-5">
                                <div className="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    Showing {results} entries
                                </div>
                            </div>
                            <div className="col-sm-7">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
});

ReactDOM.render(
  <PasswordContent url="/password/get"/>,
  document.getElementById('retrieve_password')
);