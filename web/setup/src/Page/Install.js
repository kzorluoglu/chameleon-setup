import Button from 'react-bootstrap/Button';
import Col from 'react-bootstrap/Col';
import Row from 'react-bootstrap/Row';
import {LinkContainer} from 'react-router-bootstrap'
import {
    BsFillArrowLeftSquareFill,
    BsFillArrowRightSquareFill,
    BsArrowRepeat
} from "react-icons/bs";
import {Component} from "react";


export default class Install extends Component {


    constructor(props) {
        super(props);
        this.state = {
            data: [],
            installable: false,
        }

        const output = document.getElementById('output');

        let eventSource = new EventSource("http://localhost:3333/setup/index.php?page=composerinstall")
        eventSource.addEventListener('message', e => {

                this.addNewLine(e.data);
                if (e.data === 'Done!') {
                    eventSource.close()
                    this.setState({
                        installable: true
                    })
                    return;
                }

                if (output) {
                    output.scrollTop = output.scrollHeight;
                }
            }
        )
        eventSource.addEventListener('close', () =>
            eventSource.close()
        )

    }

    componentDidMount() {
        this.addNewLine = this.addNewLine.bind(this)
    }

    addNewLine(data) {
        if (data === '') {
            data = "-";
        }

        const oldData = this.state.data;
        oldData.push(data);
        this.setState({
            data: oldData
        })

    }

    pageReload() {
        window.location.reload();
    }


    render() {
        const {data, installable} = this.state;
        return <Row>
            <Col>
                <div className="p-5">
                    <div className="mb-5">
                        <span className="badge bg-secondary">Step 3</span>
                        <h3 className="h4 font-weight-bold text-theme">Installation</h3>
                    </div>
                    <div id="output" className="terminal">
                        {data.map(item => (
                            <p key={item}>{item}</p>
                        ))}
                    </div>

                    {installable ?
                        <p className="text-success mt-2 mb-5">Congratulations! Everything looks good, you can now
                            install the software. </p>
                        :
                        <p className="text-danger mt-2 mb-5">Ups, the system requirements are not met, please try
                            again
                            after completing the required items from the list.</p>
                    }

                    <Row>
                        <Col>
                            <LinkContainer to="/requirements">
                                <Button variant="primary"><BsFillArrowLeftSquareFill/> Check System
                                    requirements</Button>
                            </LinkContainer>
                        </Col>
                        <Col>
                            {installable ?
                                <LinkContainer to="/database">
                                    <Button variant="primary"><BsFillArrowRightSquareFill/> Database
                                        Validation</Button>
                                </LinkContainer>
                                :
                                <Button variant="primary" onClick={this.pageReload}>
                                    <BsArrowRepeat/> Re-Install
                                </Button>
                            }
                        </Col>
                    </Row>
                </div>
            </Col>
        </Row>
    }
}