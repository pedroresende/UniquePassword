var Content = React.createClass({
  render: function() {
    return (
        <tr role="row" className="even">
            <td className="sorting_1"><i className={"fa " + this.props.content.icon}></i></td>
            <td>{this.props.content.name}</td>
            <td>{this.props.content.categoryCounter}</td>
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
var ListCategories = React.createClass({
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
        $('#list_categories').DataTable( {
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "sDom": 'lfrtip'
        });
    },
    render: function() {
        return (
            <div className="row">
                <div className="col-xs-12">
                    <div className="box">
                        <div className="box-body">
                            <div id="example2_wrapper" className="dataTables_wrapper form-inline dt-bootstrap">
                                <div className="row">
                                    <div className="col-sm-6"></div>
                                    <div className="col-sm-6"></div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-12">
                                        <table id="list_categories" className="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                    <th className="sorting_asc" tabIndex="0" aria-controls="example2" rowSpan="1" colSpan="1" aria-sort="ascending" aria-label="Icon">Icon</th>
                                                    <th className="sorting" tabIndex="0" aria-controls="example2" rowSpan="1" colSpan="1" aria-label="Category">Category</th>
                                                    <th className="sorting" tabIndex="0" aria-controls="example2" rowSpan="1" colSpan="1" aria-label="N Type">Number of Type</th>
                                                </tr>
                                            </thead>
                                            <ListContent data={this.state.data} />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
});

ReactDOM.render(
  <ListCategories url='/categories/get'/>,
  document.getElementById('retrieve_categories')
);
