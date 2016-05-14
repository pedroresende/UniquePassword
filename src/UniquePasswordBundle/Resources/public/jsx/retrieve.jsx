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
                <a href={view} className="btn btn-sm btn-primary">View/Edit</a>&nbsp;
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
    componentWillMount: function () {
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
    componentDidUpdate: function () {
        $('#list_passwords').DataTable( {
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "sDom": 'lfrtip'
        });
    },
    render: function () {
        var results = this.state.data.length;
        return (
            <div className="box">
                <div className="box-header">
                    <h3 className="box-title">List of Passwords</h3>
                </div>
                <div className="box-body">
                    <div id="results" className="dataTables_wrapper form-inline dt-bootstrap">
                        <div className="row">
                            <div className="col-sm-12">
                                <table id="list_passwords" className="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
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
