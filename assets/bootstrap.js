import { startStimulusApp } from '@symfony/stimulus-bridge';
import SortableController from './controllers/sortable_controller';
import RenameController from './controllers/rename_controller';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context('@symfony/stimulus-bridge/lazy-controller-loader!./controllers', true, /\.[jt]sx?$/));
// register any custom, 3rd party controllers here
app.register('sortable', SortableController);
app.register('rename', RenameController);
// export { app };
