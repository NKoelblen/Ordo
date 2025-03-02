import { startStimulusApp } from '@symfony/stimulus-bridge';

const app = startStimulusApp(require.context('./', true, /\.js$/));
export default app;
