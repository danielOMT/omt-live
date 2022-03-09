import Alpine from 'alpinejs';

import JobProfile from './views/User/JobProfile';
import JobProfilesDashboard from './views/Admin/Dashboard/JobProfiles';
import ToolsModule from './modules/Tools';
import LoadMoreArticles from './views/Article/LoadMore';
import ArticleFilter from './views/Article/Filter';

window.xJobProfile = JobProfile;
window.xJobProfilesDashboard = JobProfilesDashboard;
window.xToolsModule = ToolsModule;
window.xLoadMoreArticles = LoadMoreArticles;
window.xArticleFilter = ArticleFilter;

window.Alpine = Alpine;
Alpine.start();
