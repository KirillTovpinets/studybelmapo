import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TotalListComponent } from './total-list.component';

describe('TotalListComponent', () => {
  let component: TotalListComponent;
  let fixture: ComponentFixture<TotalListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TotalListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TotalListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
