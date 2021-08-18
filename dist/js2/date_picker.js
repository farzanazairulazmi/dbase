angular.module('kperak').filter('unsafe', unSafe);
angular.module('kperak').directive('datepicker', datePicker);

/** Directive **/
function unSafe($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    }
}


function datePicker() {
	return {
		restrict: 'A',
		require: 'ngModel',
		link: function(scope, element, attr, ctrl) {
			element.datepicker({
				dateFormat: 'yy-mm-dd', //DD, d MM, yy',
				onSelect: function(date) {
					ctrl.$setViewValue(date);
					ctrl.$render();
					scope.$apply();
				}
			});
		}
	}
}