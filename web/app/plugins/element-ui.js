import Vue from 'vue';

import Container from 'element-ui/lib/container';
import Aside from 'element-ui/lib/aside';
import Header from 'element-ui/lib/header';
import Main from 'element-ui/lib/main';
import Row from 'element-ui/lib/row';
import Col from 'element-ui/lib/col';

import Message from 'element-ui/lib/message';
import Notification from 'element-ui/lib/notification';
import MessageBox from 'element-ui/lib/message-box';

import Avatar from 'element-ui/lib/avatar';
import Alert from 'element-ui/lib/alert';
import Badge from 'element-ui/lib/badge';

import Form from 'element-ui/lib/form';
import FormItem from 'element-ui/lib/form-item';

import Button from 'element-ui/lib/button';
import Input from 'element-ui/lib/input';
import Select from 'element-ui/lib/select';
import Option from 'element-ui/lib/option';
import OptionGroup from 'element-ui/lib/option-group';
import Switch from 'element-ui/lib/switch';
import Checkbox from 'element-ui/lib/checkbox';
import Radio from 'element-ui/lib/radio';
import RadioButton from 'element-ui/lib/radio-button';
import RadioGroup from 'element-ui/lib/radio-group';
import Autocomplete from 'element-ui/lib/autocomplete';
import DatePicker from 'element-ui/lib/date-picker';

import Dialog from 'element-ui/lib/dialog';
import Popconfirm from 'element-ui/lib/popconfirm';
import Popover from 'element-ui/lib/popover';
import Dropdown from 'element-ui/lib/dropdown';
import DropdownMenu from 'element-ui/lib/dropdown-menu';
import DropdownItem from 'element-ui/lib/dropdown-item';
import Tooltip from 'element-ui/lib/tooltip';

import Table from 'element-ui/lib/table';
import TableColumn from 'element-ui/lib/table-column';
import Card from 'element-ui/lib/card';
import Menu from 'element-ui/lib/menu';
import Submenu from 'element-ui/lib/submenu';
import MenuItem from 'element-ui/lib/menu-item';
import Breadcrumb from 'element-ui/lib/breadcrumb';
import BreadcrumbItem from 'element-ui/lib/breadcrumb-item';
import Collapse from 'element-ui/lib/collapse';
import CollapseItem from 'element-ui/lib/collapse-item';
import Tree from 'element-ui/lib/tree';

import Tag from 'element-ui/lib/tag';

import Scrollbar from 'element-ui/lib/scrollbar';
import Pagination from 'element-ui/lib/pagination';

import Steps from 'element-ui/lib/steps';
import Step from 'element-ui/lib/step';
import Image from 'element-ui/lib/image';

import Progress from 'element-ui/lib/progress';

import Tabs from 'element-ui/lib/tabs';
import TabPane from 'element-ui/lib/tab-pane';
import Loading from 'element-ui/lib/loading';

export default () => {
    Vue.component('ElContainer', Container);
    Vue.component('ElAside', Aside);
    Vue.component('ElHeader', Header);
    Vue.component('ElMain', Main);
    Vue.component('ElRow', Row);
    Vue.component('ElCol', Col);

    Vue.component('ElAvatar', Avatar);
    Vue.component('ElAlert', Alert);
    Vue.component('ElBadge', Badge);

    Vue.component('ElForm', Form);
    Vue.component('ElFormItem', FormItem);

    Vue.component('ElButton', Button);
    Vue.component('ElInput', Input);
    Vue.component('ElSelect', Select);
    Vue.component('ElOption', Option);
    Vue.component('ElOptionGroup', OptionGroup);
    Vue.component('ElSwitch', Switch);
    Vue.component('ElCheckbox', Checkbox);
    Vue.component('ElRadio', Radio);
    Vue.component('ElRadioButton', RadioButton);
    Vue.component('ElRadioGroup', RadioGroup);
    Vue.component('ElAutocomplete', Autocomplete);
    Vue.component('ElDatePicker', DatePicker);

    Vue.component('ElTooltip', Tooltip);
    Vue.component('ElDialog', Dialog);
    Vue.component('ElPopconfirm', Popconfirm);
    Vue.component('ElPopover', Popover);
    Vue.component('ElDropdown', Dropdown);
    Vue.component('ElDropdownMenu', DropdownMenu);
    Vue.component('ElDropdownItem', DropdownItem);

    Vue.component('ElTable', Table);
    Vue.component('ElTableColumn', TableColumn);
    Vue.component('ElCard', Card);
    Vue.component('ElMenu', Menu);
    Vue.component('ElSubmenu', Submenu);
    Vue.component('ElMenuItem', MenuItem);
    Vue.component('ElBreadcrumb', Breadcrumb);
    Vue.component('ElBreadcrumbItem', BreadcrumbItem);
    Vue.component('ElCollapse', Collapse);
    Vue.component('ElCollapseItem', CollapseItem);
    Vue.component('ElTree', Tree);
    Vue.component('ElTag', Tag);

    Vue.component('ElScrollbar', Scrollbar);
    Vue.component('ElPagination', Pagination);

    Vue.component('ElSteps', Steps);
    Vue.component('ElStep', Step);
    Vue.component('ElImage', Image);

    Vue.component('ElProgress', Progress);

    Vue.component('ElTabs', Tabs);
    Vue.component('ElTabPane', TabPane);

    Vue.use(Loading.directive);

    Vue.prototype.$msgbox = MessageBox;
    Vue.prototype.$alert = MessageBox.alert;
    Vue.prototype.$confirm = MessageBox.confirm;
    Vue.prototype.$prompt = MessageBox.prompt;
    Vue.prototype.$notify = Notification;
    Vue.prototype.$message = Message;
};
